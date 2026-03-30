<?php

namespace App\WhatsApp;

class MarketingMessage extends WhatsAppMessage
{
    public function build()
    {
        $client = $this->data['client'];
        $content = $this->data['content'] ?? '';
        $subject = $this->data['subject'] ?? $this->trans('whatsapp.marketing.default_subject');
        $restaurantName = config('app.name');

        $message = $this->trans('whatsapp.marketing.greeting', ['name' => $client->name]) . "\n\n";
        
        // Add subject if provided
        if ($subject) {
            $message .= "📢 " . $subject . "\n\n";
        }
        
        // Add main content
        if ($content) {
            $message .= $content . "\n\n";
        }
        
        // Add personalized recommendations if available
        if (isset($this->data['recommendations'])) {
            $message .= "🍽️ " . $this->trans('whatsapp.marketing.recommendations') . "\n";
            $message .= "━━━━━━━━━━━━━━━━━━━━\n";
            
            foreach ($this->data['recommendations'] as $recommendation) {
                $message .= "• " . $recommendation['name'];
                if (isset($recommendation['price'])) {
                    $message .= " - " . $this->formatCurrency($recommendation['price']);
                }
                $message .= "\n";
            }
            $message .= "\n";
        }
        
        // Add special offers if available
        if (isset($this->data['offers'])) {
            $message .= "🎉 " . $this->trans('whatsapp.marketing.special_offers') . "\n";
            $message .= "━━━━━━━━━━━━━━━━━━━━\n";
            
            foreach ($this->data['offers'] as $offer) {
                $message .= "• " . $offer . "\n";
            }
            $message .= "\n";
        }
        
        // Add contact information
        $message .= $this->trans('whatsapp.marketing.contact_us') . "\n";
        $message .= $this->trans('whatsapp.marketing.visit_us') . "\n\n";
        
        $message .= $this->trans('whatsapp.marketing.signature', ['restaurant' => $restaurantName]);

        return [
            'message' => $message,
            'media' => $this->data['media'] ?? null
        ];
    }
}
