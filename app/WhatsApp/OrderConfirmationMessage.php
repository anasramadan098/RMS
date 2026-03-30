<?php

namespace App\WhatsApp;

class OrderConfirmationMessage extends WhatsAppMessage
{
    public function build()
    {
        $order = $this->data['order'];
        $client = $this->data['client'];
        $restaurantName = config('app.name');

        $message = $this->trans('whatsapp.order_confirmation.greeting', ['name' => $client->name]) . "\n\n";
        $message .= $this->trans('whatsapp.order_confirmation.confirmed') . "\n\n";
        
        // Order details
        $message .= "📋 " . $this->trans('whatsapp.order_confirmation.order_details') . "\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━\n";
        $message .= $this->trans('whatsapp.order_confirmation.order_number') . ": #" . $order->id . "\n";
        $message .= $this->trans('whatsapp.order_confirmation.order_date') . ": " . $this->formatDate($order->created_at) . "\n";
        
        if ($order->table_number) {
            $message .= $this->trans('whatsapp.order_confirmation.table_number') . ": " . $order->table_number . "\n";
        }
        
        $message .= "\n🍽️ " . $this->trans('whatsapp.order_confirmation.items') . "\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━\n";
        
        foreach ($order->orderItems as $item) {
            $message .= "• " . $item->meal->name_en. " x" . $item->quantity;
            $message .= " - " . $this->formatCurrency($item->price * $item->quantity) . "\n";
        }
        
        $message .= "━━━━━━━━━━━━━━━━━━━━\n";
        $message .= $this->trans('whatsapp.order_confirmation.total') . ": " . $this->formatCurrency($order->total_amount) . "\n\n";
        
        // Estimated time
        $estimatedTime = $order->created_at->addMinutes(30); // Assuming 30 minutes preparation time
        $message .= "⏰ " . $this->trans('whatsapp.order_confirmation.estimated_time') . ": ";
        $message .= $this->formatTime($estimatedTime) . "\n\n";
        
        $message .= $this->trans('whatsapp.order_confirmation.thank_you') . "\n";
        $message .= $this->trans('whatsapp.order_confirmation.signature', ['restaurant' => $restaurantName]);

        return [
            'message' => $message,
            'media' => null
        ];
    }
}
