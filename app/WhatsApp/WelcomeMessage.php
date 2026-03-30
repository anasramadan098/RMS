<?php

namespace App\WhatsApp;

class WelcomeMessage extends WhatsAppMessage
{
    public function build()
    {
        $clientName = $this->data['client_name'] ?? $this->trans('app.dear_customer');
        $restaurantName = config('app.name');

        $message = $this->trans('whatsapp.welcome.greeting', ['name' => $clientName]) . "\n\n";
        $message .= $this->trans('whatsapp.welcome.message', ['restaurant' => $restaurantName]) . "\n\n";
        $message .= $this->trans('whatsapp.welcome.features') . "\n";
        $message .= "• " . $this->trans('whatsapp.welcome.feature_1') . "\n";
        $message .= "• " . $this->trans('whatsapp.welcome.feature_2') . "\n";
        $message .= "• " . $this->trans('whatsapp.welcome.feature_3') . "\n\n";
        $message .= $this->trans('whatsapp.welcome.closing') . "\n";
        $message .= $this->trans('whatsapp.welcome.signature', ['restaurant' => $restaurantName]);

        return [
            'message' => $message,
            'media' => null
        ];
    }
}
