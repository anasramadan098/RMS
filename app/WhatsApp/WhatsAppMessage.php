<?php

namespace App\WhatsApp;

use App\Services\WhatsAppService;
use Illuminate\Support\Facades\App;

abstract class WhatsAppMessage
{
    protected $to;
    protected $data;
    protected $locale;

    public function __construct($to, $data = [])
    {
        $this->to = $to;
        $this->data = $data;
        $this->locale = App::getLocale();
    }

    /**
     * Set the recipient phone number
     */
    public function to($phone)
    {
        $this->to = $phone;
        return $this;
    }

    /**
     * Set the locale for the message
     */
    public function locale($locale)
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * Set additional data for the message
     */
    public function with($data)
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    /**
     * Build the message content
     */
    abstract public function build();

    /**
     * Send the WhatsApp message
     */
    public function send()
    {
        $whatsappService = new WhatsAppService();
        
        if (!$whatsappService->isEnabled()) {
            throw new \Exception('WhatsApp service is not enabled');
        }

        if (!$whatsappService->validatePhoneNumber($this->to)) {
            throw new \Exception('Invalid phone number format');
        }

        $content = $this->build();
        
        return $whatsappService->sendMessage(
            $this->to,
            $content['message'],
            $content['media'] ?? null
        );
    }

    /**
     * Get translated text
     */
    protected function trans($key, $replace = [])
    {
        return __($key, $replace, $this->locale);
    }

    /**
     * Format phone number for display
     */
    protected function formatPhone($phone)
    {
        return preg_replace('/(\d{3})(\d{3})(\d{4})/', '$1-$2-$3', $phone);
    }

    /**
     * Format currency
     */
    protected function formatCurrency($amount)
    {
        return number_format($amount, 2) . ' ' . $this->trans('app.currency');
    }

    /**
     * Format date
     */
    protected function formatDate($date)
    {
        return $date->format($this->locale === 'ar' ? 'd/m/Y' : 'm/d/Y');
    }

    /**
     * Format time
     */
    protected function formatTime($time)
    {
        return $time->format($this->locale === 'ar' ? 'H:i' : 'h:i A');
    }
}
