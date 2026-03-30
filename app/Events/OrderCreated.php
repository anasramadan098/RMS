<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order->load(['client', 'orderItems.meal']);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('kitchen'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'order.created';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'order' => [
                'id' => $this->order->id,
                'order_number' => $this->order->order_number,
                'client_name' => $this->order->client->name ?? 'عميل مجهول',
                'table_number' => $this->order->table_number,
                'status' => $this->order->status,
                'total_amount' => $this->order->total_amount,
                'special_instructions' => $this->order->notes,
                'created_at' => $this->order->created_at->format('H:i'),
                'items' => $this->order->orderItems->map(function ($item) {
                    return [
                        'meal_name' => $item->meal->name_en ?? 'وجبة محذوفة',
                        'quantity' => $item->quantity,
                        'price' => $item->unit_price,
                        'notes' => $item->special_instructions,
                    ];
                })->toArray(),
            ]
        ];
    }
}
