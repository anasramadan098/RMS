<?php

namespace App\Http\Controllers;

use App\Events\OrderStatusUpdated;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class KitchenController extends Controller
{
    /**
     * Display the kitchen dashboard with pending orders.
     */
    public function index()
    {
        // Get only pending orders with their relationships
        $orders = Order::with(['client', 'orderItems.meal'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('kitchen.index', compact('orders'));
    }

    /**
     * Update order status to completed.
     */
    public function completeOrder(Request $request, Order $order)
    {
        try {
            // Security check: Only allow updating pending orders
            if ($order->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'لا يمكن تحديث هذا الطلب - الحالة الحالية: ' . $order->status
                ], 403);
            }

            $oldStatus = $order->status;

            // Update order status - only update fields that exist in the table
            $updateData = [
                'status' => 'delivered', // Use 'delivered' instead of 'completed' based on migration
            ];

            // Only add these fields if they exist in the orders table
            $orderColumns = Schema::getColumnListing('orders');

            if (in_array('completed_at', $orderColumns)) {
                $updateData['completed_at'] = now();
            }

            if (in_array('completed_by', $orderColumns)) {
                $updateData['completed_by'] = Auth::id();
            }

            $order->update($updateData);

            // Reload the order to get fresh data
            $order->refresh();

            // Try to broadcast the status update (but don't fail if it doesn't work)
            try {
                if (class_exists('App\Events\OrderStatusUpdated')) {
                    broadcast(new OrderStatusUpdated($order, $oldStatus));
                }
            } catch (\Exception $broadcastError) {
                // Log the error but don't fail the request
                Log::warning('Failed to broadcast order status update: ' . $broadcastError->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'تم إكمال الطلب بنجاح',
                'order_id' => $order->id,
                'new_status' => $order->status
            ]);

        } catch (\Exception $e) {
            Log::error('Error completing order: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث الطلب: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get pending orders for AJAX refresh.
     */
    public function getPendingOrders()
    {
        try {
            $orders = Order::with(['client', 'orderItems.meal'])
                ->where('status', 'pending')
                ->orderBy('created_at', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'orders' => $orders->map(function ($order) {
                    return [
                        'id' => $order->id,
                        'order_number' => $order->order_number,
                        'client_name' => $order->client->name ?? 'عميل مجهول',
                        'client_phone' => $order->client->phone ?? '',
                        'table_number' => $order->table_number,
                        'total_amount' => $order->total_amount,
                        'special_instructions' => $order->notes ?? '',
                        'created_at' => $order->created_at->format('H:i'),
                        'items' => $order->orderItems->map(function ($item) {
                            return [
                                'meal_name' => $item->meal->name_en?? 'وجبة محذوفة',
                                'quantity' => $item->quantity,
                                'price' => $item->unit_price ?? $item->total_price,
                                'notes' => $item->special_instructions ?? '',
                            ];
                        }),
                    ];
                })
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء جلب الطلبات'
            ], 500);
        }
    }
}
