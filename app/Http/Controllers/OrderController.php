<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Events\OrderStatusUpdated;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\Meal;
use App\Models\User;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['user', 'client', 'orderItems.meal'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        return view('sales.index' , compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $meals = Meal::available()->active()->with(['category', 'ingredients'])->get();
        $clients = Client::all();
        return view('sales.create' , compact('meals' , 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // Log incoming request for debugging
        if ($request->has('fromJs')) {
            Log::info('Order creation request from JS:', [
                'client_id' => $request->client_id,
                'table_number' => $request->table_number,
                'items' => $request->items,
                'order_type' => $request->order_type,
                'payment_type' => $request->payment_type,
            ]);
        }

        $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'order_type' => 'required',
            'table_number' => 'required',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            // تحويل items إلى array إذا كان string (من JavaScript)
            $items = $request->items;
            Log::info('Items before processing:', ['items' => $items, 'type' => gettype($items)]);

            if (is_string($items)) {
                $items = json_decode($items, true);
                Log::info('Items after JSON decode:', ['items' => $items, 'json_error' => json_last_error_msg()]);
            }

            // التأكد من وجود items
            if (empty($items) || !is_array($items)) {
                Log::error('Items validation failed:', ['items' => $items, 'is_array' => is_array($items), 'empty' => empty($items)]);
                throw new \Exception(__('orders.no_items_selected'));
            }

            // التحقق من توفر المكونات قبل إنشاء الطلب
            // $this->checkIngredientsAvailability($items);

            // حساب المجاميع
            $subtotal = 0;
            $orderItems = [];

            foreach ($items as $item) {
                Log::info('Processing item:', $item);

                if (!isset($item['meal_id'])) {
                    throw new \Exception('Meal ID is required for each item');
                }

                $meal = Meal::find($item['meal_id']);
                if (!$meal) {
                    throw new \Exception("Meal with ID {$item['meal_id']} not found");
                }

                Log::info('Found meal:', ['meal' => $meal->name, 'price' => $meal->price]);

                // التحقق من توفر الوجبة (تعطيل مؤقت للاختبار)
                // if (!$meal->is_available || !$meal->is_active) {
                //     throw new \Exception("الوجبة '{$meal->name}' غير متوفرة حالياً");
                // }

                // If The Order From Employee
                if ($request->employee_id) {
                    $employee = User::find($request->employee_id);

                    $meals = json_decode($employee->meals, true); // decode as associative array

                    if (is_array($meals)) {
                        foreach ($meals as &$employeeMeal) {
                            if (isset($employeeMeal['id']) && $employeeMeal['id'] == $meal->id) {
                                if (isset($employeeMeal['qty']) && $employeeMeal['qty'] > 0) {
                                    $employeeMeal['qty'] -= $item['quantity'] ?? 1;
                                    if ($employeeMeal['qty'] < 0) {
                                        $employeeMeal['qty'] = 0;
                                    }
                                }
                            }
                        }
                        unset($employeeMeal); // break reference

                        // Save updated meals back to employee
                        $employee->meals = json_encode($meals);
                        $employee->save();
                    }
                }

                $quantity = $item['quantity'] ?? 1;
                $size = $item['size'] ?? 'sm';
                $itemTotal = $meal->price * $quantity;
                $subtotal += $itemTotal;

                $orderItems[] = [
                    'meal_id' => $meal->id,
                    'quantity' => $quantity,
                    'unit_price' => $meal->price,
                    'total_price' => $itemTotal,
                    'size' => $size,
                    'special_instructions' => $item['special_instructions'] ?? null,
                ];

                Log::info('Added order item:', ['meal_id' => $meal->id, 'quantity' => $quantity, 'total' => $itemTotal]);
            }

            $taxAmount = $subtotal * 0.14; // 15% ضريبة
            $deliveryFee = $request->order_type === 'delivery' ? 10 : 0;
            $discount_amount = $request['discount'] ?? $request['discount_amount'];
            if ($discount_amount == null) {
                $discount_amount = 0;
            }
            $totalAmount = $subtotal + $taxAmount + $deliveryFee - $discount_amount;

            Log::info('Order totals calculated:', [
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'delivery_fee' => $deliveryFee,
                'total_amount' => $totalAmount
            ]);


            $the_en_order_type = '';
            if( $request->order_type == 'تناول هنا') {
                $the_en_order_type = 'dine_in';
            } else if ($request->order_type == 'استلام') {
                $the_en_order_type = 'takeaway';
            } else if ($request->order_type == 'توصيل') {
                $the_en_order_type = 'delivery';
            } else {
                $the_en_order_type = $request->order_type;
            }

            

            // إنشاء الطلب
            $orderData = [
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'user_id' => Auth::id(),
                'client_id' => $request->client_id,
                'order_type' => $the_en_order_type,
                'table_number' => $request->table_number,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'delivery_fee' => $deliveryFee,
                'total_amount' => $request->employee_id ? 0 : $totalAmount,
                'status' => 'pending',
                'discount_amount' => $discount_amount,
                'notes' => $request->notes,
            ];

            Log::info('Creating order with data:', $orderData);

            $order = Order::create($orderData);

            Log::info('Order created successfully:', ['order_id' => $order->id]);

            // إنشاء عناصر الطلب
            if (!empty($orderItems)) {
                foreach ($orderItems as $item) {
                    $order->orderItems()->create($item);
                }
            }

            // خصم المكونات من المخزون
            // $this->deductIngredientsFromStock($order);

            // تحميل العلاقات للعرض
            $order->load(['orderItems.meal', 'user', 'client']);

            DB::commit();

            // Broadcast the new order to kitchen (only if broadcasting is properly configured)
            try {
                if (config('broadcasting.default') !== 'null' &&
                    config('broadcasting.connections.pusher.key') !== 'your_app_key') {
                    broadcast(new OrderCreated($order));
                }
            } catch (\Exception $e) {
                // Log the broadcasting error but don't fail the order creation
                Log::warning('Failed to broadcast order creation: ' . $e->getMessage());
            }
            
            if (request()->has('fromJs')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order created successfully.',
                    'order' => $order,
                ]);
            }

            return redirect()->route('orders.index')->with('msg', __('orders.order_created'));

        } catch (\Exception $e) {
            DB::rollBack();

            // Log the error for debugging
            Log::error('Order creation failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            if (request()->has('fromJs')) {
                return response()->json([
                    'success' => false,
                    'message' => __('orders.order_creation_failed') . ': ' . $e->getMessage(),
                    'error_details' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                           ->withErrors(['error' => __('orders.order_creation_failed') . ': ' . $e->getMessage()])
                           ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {   
        
        $order->load(['user', 'client', 'orderItems.meal.category', 'orderItems.meal.ingredients']);
        return view('sales.show' , compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $order->load(['orderItems.meal']);
        $meals = Meal::available()->active()->with(['category', 'ingredients'])->get();
        $clients = Client::all();
        return view('sales.edit' , compact('order' , 'meals' , 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,ready,delivered,cancelled',
            'prepared_at' => 'nullable|date',
            'delivered_at' => 'nullable|date',
        ]);

        $order->update($request->all());
        $order->load(['orderItems.meal', 'user', 'client']);
        return redirect()->route('orders.index')->with('msg', __('orders.order_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        if (!$order->canBeCancelled()) {
            abort(403, __('app.unauthorized'));
        }

        $order->update(['status' => 'cancelled']);
        $order->delete();
        return redirect()->route('orders.index')->with('msg', __('orders.order_cancelled'));
    }

    /**
     * Check if ingredients are available for the order items.
     */
    private function checkIngredientsAvailability(array $items)
    {
        foreach ($items as $item) {
            $meal = Meal::with('ingredients')->findOrFail($item['meal_id']);
            $orderQuantity = $item['quantity'];

            foreach ($meal->ingredients as $ingredient) {
                $requiredQuantity = $ingredient->pivot->quantity * $orderQuantity;

                if ($ingredient->stock_quantity < $requiredQuantity) {
                    throw new \Exception("المكون '{$ingredient->name}' غير متوفر بالكمية المطلوبة للوجبة '{$meal->name}'");
                }
            }
        }
    }

    /**
     * Deduct ingredients from stock when order is created.
     */
    private function deductIngredientsFromStock(Order $order)
    {
        foreach ($order->orderItems as $orderItem) {
            $meal = $orderItem->meal->load('ingredients');
            $orderQuantity = $orderItem->quantity;

            foreach ($meal->ingredients as $ingredient) {
                $requiredQuantity = $ingredient->pivot->quantity * $orderQuantity;

                // خصم الكمية من المخزون
                $ingredient->decrement('stock_quantity', $requiredQuantity);
            }
        }
    }

    /**
     * Get orders by status.
     */
    public function byStatus($status)
    {
        $orders = Order::withStatus($status)
                      ->with(['user', 'orderItems.meal'])
                      ->orderBy('created_at', 'desc')
                      ->get();
        return response()->json($orders);
    }

    /**
     * Get orders by type.
     */
    public function byType($type)
    {
        $orders = Order::ofType($type)
                      ->with(['user', 'client', 'orderItems.meal'])
                      ->orderBy('created_at', 'desc')
                      ->get();
        return response()->json($orders);
    }

    /**
     * Get orders by client.
     */
    public function byClient($clientId)
    {
        $orders = Order::byClient($clientId)
                      ->with(['user', 'client', 'orderItems.meal'])
                      ->orderBy('created_at', 'desc')
                      ->get();
        return response()->json($orders);
    }

    /**
     * Get orders by table number.
     */
    public function byTable($tableNumber)
    {
        $orders = Order::byTable($tableNumber)
                      ->with(['user', 'client', 'orderItems.meal'])
                      ->orderBy('created_at', 'desc')
                      ->get();
        return response()->json($orders);
    }

    /**
     * Get client order history.
     */
    public function clientHistory($clientId)
    {
        $orders = Order::getClientOrderHistory($clientId);
        return response()->json($orders);
    }

    /**
     * Get table orders.
     */
    public function tableOrders($tableNumber, Request $request)
    {
        $status = $request->query('status');
        $orders = Order::getTableOrders($tableNumber, $status);
        return response()->json($orders);
    }

    public function menu_order() {
        Order::create(request());
        return response(request());
    }
}
