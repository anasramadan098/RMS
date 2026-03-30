<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Exception;

class WhatsAppService
{
    protected $twilio;
    protected $from;

    public function __construct()
    {
        $this->twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.auth_token')
        );
        $this->from = config('services.twilio.whatsapp_from');
    }

    /**
     * Send WhatsApp message
     */
    public function sendMessage($to, $message, $mediaUrl = null)
    {
        try {
            // Ensure phone number is in correct format
            $to = $this->formatPhoneNumber($to);
            
            $messageData = [
                'from' => $this->from,
                'body' => $message
            ];

            // Add media if provided
            if ($mediaUrl) {
                $messageData['mediaUrl'] = [$mediaUrl];
            }

            $message = $this->twilio->messages->create(
                $to,
                $messageData
            );

            Log::info('WhatsApp message sent successfully', [
                'to' => $to,
                'message_sid' => $message->sid,
                'status' => $message->status
            ]);

            return [
                'success' => true,
                'message_sid' => $message->sid,
                'status' => $message->status
            ];

        } catch (Exception $e) {
            Log::error('Failed to send WhatsApp message', [
                'to' => $to,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send template message
     */
    public function sendTemplate($to, $templateSid, $variables = [])
    {
        try {
            $to = $this->formatPhoneNumber($to);

            $message = $this->twilio->messages->create(
                $to,
                [
                    'from' => $this->from,
                    'contentSid' => $templateSid,
                    'contentVariables' => json_encode($variables)
                ]
            );

            Log::info('WhatsApp template message sent successfully', [
                'to' => $to,
                'template_sid' => $templateSid,
                'message_sid' => $message->sid
            ]);

            return [
                'success' => true,
                'message_sid' => $message->sid,
                'status' => $message->status
            ];

        } catch (Exception $e) {
            Log::error('Failed to send WhatsApp template message', [
                'to' => $to,
                'template_sid' => $templateSid,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Format phone number for WhatsApp
     */
    protected function formatPhoneNumber($phone)
    {
        // Remove any non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Add country code if not present (assuming Saudi Arabia +966)
        if (!str_starts_with($phone, '966') && !str_starts_with($phone, '+966')) {
            if (str_starts_with($phone, '0')) {
                $phone = '966' . substr($phone, 1);
            } else {
                $phone = '966' . $phone;
            }
        }

        // Remove + if present
        $phone = ltrim($phone, '+');

        return 'whatsapp:+' . $phone;
    }

    /**
     * Validate phone number
     */
    public function validatePhoneNumber($phone)
    {
        // Remove any non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Check if it's a valid Saudi phone number
        if (preg_match('/^(966|0)?5[0-9]{8}$/', $phone)) {
            return true;
        }

        // Check if it's a valid international number (basic validation)
        if (preg_match('/^[1-9][0-9]{7,14}$/', $phone)) {
            return true;
        }

        return false;
    }

    /**
     * Get message status
     */
    public function getMessageStatus($messageSid)
    {
        try {
            $message = $this->twilio->messages($messageSid)->fetch();
            
            return [
                'success' => true,
                'status' => $message->status,
                'error_code' => $message->errorCode,
                'error_message' => $message->errorMessage
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Check if WhatsApp is enabled
     */
    public function isEnabled()
    {
        return config('services.twilio.whatsapp_enabled', false) && 
               !empty(config('services.twilio.sid')) && 
               !empty(config('services.twilio.auth_token'));
    }
}
