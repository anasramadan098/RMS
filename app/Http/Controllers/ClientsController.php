<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Meal;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use App\Services\FilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, FilterService $filterService)
    {
        // Create a model instance for filter configuration
        $clientModel = new Client();

        // Extract filters from request
        $filters = $filterService->extractFilters($request, array_keys($clientModel->getFilterableAttributes()));

        // Apply filters to the query with order counts
        $query = Client::withCount('orders');
        if (!empty($filters)) {
            $query = $query->filter($filters);
        }

        // Get filtered clients with pagination
        $clients = $query->paginate(10)->withQueryString();

        // Get filter data for the view
        $filterData = $filterService->getFilterData($clientModel, $filters);

        return view('clients.index', compact('clients', 'filterData', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('meals')->where('is_active', true)->get();
        $meals = Meal::where('is_active', true)->where('is_available', true)->get();

        return view('clients.create', compact('categories', 'meals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'nullable|string|max:20',
            'whatsapp_phone' => 'nullable|string|max:20',
            'whatsapp_notifications' => 'nullable|boolean',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'notes' => 'nullable|string',
            'last_activity' => 'nullable|date',
            'type' => 'required|in:customer,lead,prospect',

            // Order fields
            'create_initial_order' => 'nullable|boolean',
            'order_type' => 'nullable|in:dine_in,takeaway,delivery',
            'table_number' => 'nullable|string|max:10',
            'order_items' => 'nullable|array',
            'order_items.*.meal_id' => 'nullable|integer|exists:meals,id',
            'order_items.*.quantity' => 'nullable|integer|min:1',
            'order_items.*.special_instructions' => 'nullable|string|max:255',
        ]);
        $client = new Client($request->all());
        if ($request->input('created_at') != null ) {
            $client->created_at = $request->input('created_at');
        } else {
            $client->created_at = now();
        }
        if ($request->input('last_activity') != null ) {
            $client->last_activity = $request->input('last_activity');
        } else {
            $client->last_activity = now();
        }
    
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/clients'), $filename);
            $client->profile_picture = 'img/clients/' . $filename;
        } else {
            $client->profile_picture = 'img/clients/default.png'; // Default image path
        }

        try {
            DB::beginTransaction();

            // Save the client first to get an ID
            $client->save();

            // Create initial order if requested
            if ($request->has('create_initial_order') && $request->create_initial_order && $request->has('order_items')) {
                $this->createInitialOrder($client, $request);
            }

            DB::commit();


            if (request()->has('fromJs')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Client created successfully.',
                    'client' => $client,
                ]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => __('clients.client_save_failed') . ': ' . $e->getMessage()])->withInput();
        }



        return redirect()->route('clients.index')->with('msg', __('clients.client_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        // Load client with all related data
        $client->load([
            'orders' => function($query) {
                $query->with(['orderItems.meal', 'user'])
                      ->orderBy('created_at', 'desc');
            }
        ]);

        // Get client statistics
        $statistics = $client->getStatistics();

        return view('clients.show', compact('client', 'statistics'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $categories = Category::with('meals')->where('is_active', true)->get();
        $meals = Meal::where('is_active', true)->where('is_available', true)->get();

        // Load client with orders for editing
        $client->load(['orders' => function($query) {
            $query->with(['orderItems.meal'])
                  ->where('status', 'pending')
                  ->orderBy('created_at', 'desc');
        }]);

        return view('clients.edit', compact('client', 'categories', 'meals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:20',
            'whatsapp_phone' => 'nullable|string|max:20',
            'whatsapp_notifications' => 'nullable|boolean',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'notes' => 'nullable|string',
            'last_activity' => 'nullable|date',
            'type' => 'required|in:customer,lead,prospect',
        ]);

        $client->fill($request->all());
        if ($request->input('created_at') != null ) {
            $client->created_at = $request->input('created_at');
        }
        if ($request->input('last_activity') != null ) {
            $client->last_activity = $request->input('last_activity');
        } else {
            $client->last_activity = now();
        }

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/clients'), $filename);
            $client->profile_picture = 'img/clients/' . $filename;
        }

        try {
            // Save the client
            $client->save();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => __('clients.client_update_failed') . ': ' . $e->getMessage()])->withInput();
        }

        return redirect()->route('clients.index')->with('msg', __('clients.client_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        // Delete the client
        $client->delete();

        return redirect()->route('clients.index')->with('msg', __('clients.client_deleted'));
    }

    /**
     * Create initial order for new client
     */
    private function createInitialOrder(Client $client, Request $request)
    {
        $orderItems = $request->input('order_items', []);

        // Filter valid order items
        $validItems = array_filter($orderItems, function($item) {
            return isset($item['meal_id']) && isset($item['quantity']) &&
                   !empty($item['meal_id']) && !empty($item['quantity']);
        });

        if (empty($validItems)) {
            return;
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($validItems as $item) {
            $meal = Meal::find($item['meal_id']);
            if ($meal) {
                $subtotal += $meal->price * $item['quantity'];
            }
        }

        $taxAmount = $subtotal * 0.15; // 15% tax
        $totalAmount = $subtotal + $taxAmount;

        // Create order
        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'client_id' => $client->id,
            'user_id' => Auth::id(),
            'order_type' => $request->input('order_type', 'dine_in'),
            'table_number' => $request->input('table_number'),
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'notes' => 'طلب أولي تم إنشاؤه مع العميل',
        ]);

        // Create order items
        foreach ($validItems as $item) {
            $meal = Meal::find($item['meal_id']);
            if ($meal) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'meal_id' => $meal->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $meal->price,
                    'total_price' => $meal->price * $item['quantity'],
                    'special_instructions' => $item['special_instructions'] ?? null,
                ]);
            }
        }

        return $order;
    }

    /**
     * Add new order to existing client
     */
    public function addOrder(Request $request, Client $client)
    {
        $request->validate([
            'order_type' => 'required|in:dine_in,takeaway,delivery',
            'table_number' => 'nullable|string|max:10',
            'order_items' => 'required|array|min:1',
            'order_items.*.meal_id' => 'required|integer|exists:meals,id',
            'order_items.*.quantity' => 'required|integer|min:1',
            'order_items.*.special_instructions' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $order = $this->createInitialOrder($client, $request);

            DB::commit();

            return redirect()->route('clients.show', $client)
                           ->with('success', __('orders.order_created'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->withErrors(['error' => __('orders.order_creation_failed') . ': ' . $e->getMessage()])
                           ->withInput();
        }
    }
    public function clients_get($id) {
        return response()->json(Client::find($id));
    }

    /**
     * Search for a client by ID, phone, or name (API for cashier)
     */
    public function searchClient(Request $request)
    {
        $search = $request->get('search');

        if (empty($search)) {
            return response()->json([
                'success' => false,
                'message' => 'يرجى إدخال معرف العميل أو رقم الهاتف'
            ]);
        }

        // Search by ID, phone, or name
        $client = Client::where('id', $search)
            ->orWhere('phone', $search)
            ->orWhere('name', 'LIKE', "%{$search}%")
            ->first();

        if ($client) {
            return response()->json([
                'success' => true,
                'client' => [
                    'id' => $client->id,
                    'name' => $client->name,
                    'phone' => $client->phone,
                    'email' => $client->email,
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'العميل غير موجود'
        ]);
    }

    // Create Client From Menu
    public function client_menu() {
        $data = request()->all();

        $link = $data['r_link'] ?? null;
        $random_code = uniqid();
        
        
        // Remove unwanted fields from $data for notes
        // Remove unwanted fields
        unset($data['_token'], $data['name'], $data['phone'], $data['r_link']);
        $usedData = json_decode($data['client_data']);

        // Prepare notes array
        $notes = [];
        
        $notes['app'] = [$usedData->app];
        $notes['vistis'] = [$usedData->lastFollow];
        $notes['table_numbers'] = [$usedData->last_table_number];
        $notes['spin'] = $usedData->spin;



        // Check if client exists
        $existingClient = Client::where('phone', request('phone'))->first();
        if ($existingClient) {
            // // Update table_numbers and lastFollow if present
            $existingNotes = json_decode($existingClient->notes, true) ?: [];
            $existingNotes['table_numbers'][] = $usedData->last_table_number;
            $existingNotes['vistis'][] = $usedData->lastFollow;

            $existingNotes['app'][] = $usedData->app;
            $existingClient->notes = json_encode($existingNotes, JSON_UNESCAPED_UNICODE);
            $existingClient->save();

            return $link ? redirect($link) : response()->json(["ok" => true, 'code' => $random_code , 'client' => $existingClient]);
        }

        // Create new client
        $client = new Client();
        $client->name = request('name');
        $client->phone = request('phone');
        $client->notes = json_encode($notes, JSON_UNESCAPED_UNICODE);
        $client->save();
        return $link ?  redirect($link) : response()->json(["ok" => true , 'code' => $random_code]);
    }



}

