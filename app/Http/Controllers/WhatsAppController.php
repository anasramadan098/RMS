<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\WhatsAppService;
use App\WhatsApp\WelcomeMessage;
use App\WhatsApp\OrderConfirmationMessage;
use App\WhatsApp\MarketingMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class WhatsAppController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    /**
     * Send welcome message to a client
     */
    public function sendWelcome(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $client = Client::findOrFail($request->client_id);

            if (!$client->whatsapp_phone || !$client->whatsapp_notifications) {
                return response()->json([
                    'success' => false,
                    'message' => __('whatsapp.errors.no_whatsapp_number')
                ], 400);
            }

            $message = new WelcomeMessage($client->whatsapp_phone, [
                'client_name' => $client->name
            ]);

            $result = $message->send();

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => __('whatsapp.messages.welcome_sent'),
                    'message_sid' => $result['message_sid']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('whatsapp.errors.send_failed'),
                    'error' => $result['error']
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp welcome message', [
                'client_id' => $request->client_id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => __('whatsapp.errors.send_failed'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send marketing message to clients
     */
    public function sendMarketing(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_ids' => 'required|array',
            'client_ids.*' => 'exists:clients,id',
            'subject' => 'nullable|string|max:255',
            'content' => 'required|string',
            'media_url' => 'nullable|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $clients = Client::whereIn('id', $request->client_ids)
                           ->where('whatsapp_notifications', true)
                           ->whereNotNull('whatsapp_phone')
                           ->get();

            $results = [];
            $successCount = 0;
            $failureCount = 0;

            foreach ($clients as $client) {
                try {
                    $message = new MarketingMessage($client->whatsapp_phone, [
                        'client' => $client,
                        'subject' => $request->subject,
                        'content' => $request->content,
                        'media' => $request->media_url
                    ]);

                    $result = $message->send();

                    if ($result['success']) {
                        $successCount++;
                        $results[] = [
                            'client_id' => $client->id,
                            'client_name' => $client->name,
                            'status' => 'sent',
                            'message_sid' => $result['message_sid']
                        ];
                    } else {
                        $failureCount++;
                        $results[] = [
                            'client_id' => $client->id,
                            'client_name' => $client->name,
                            'status' => 'failed',
                            'error' => $result['error']
                        ];
                    }

                    // Add small delay to avoid rate limiting
                    usleep(500000); // 0.5 seconds

                } catch (\Exception $e) {
                    $failureCount++;
                    $results[] = [
                        'client_id' => $client->id,
                        'client_name' => $client->name,
                        'status' => 'failed',
                        'error' => $e->getMessage()
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'message' => __('whatsapp.messages.marketing_sent', [
                    'success' => $successCount,
                    'total' => count($clients)
                ]),
                'summary' => [
                    'total_clients' => count($clients),
                    'success_count' => $successCount,
                    'failure_count' => $failureCount
                ],
                'results' => $results
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp marketing messages', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => __('whatsapp.errors.send_failed'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test WhatsApp connection
     */
    public function testConnection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            if (!$this->whatsappService->validatePhoneNumber($request->phone)) {
                return response()->json([
                    'success' => false,
                    'message' => __('whatsapp.errors.invalid_phone')
                ], 400);
            }

            $testMessage = __('whatsapp.test.message', ['app' => config('app.name')]);
            $result = $this->whatsappService->sendMessage($request->phone, $testMessage);

            return response()->json([
                'success' => $result['success'],
                'message' => $result['success']
                    ? __('whatsapp.test.success')
                    : __('whatsapp.test.failed'),
                'details' => $result
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('whatsapp.errors.connection_failed'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get WhatsApp service status
     */
    public function getStatus()
    {
        return response()->json([
            'enabled' => $this->whatsappService->isEnabled(),
            'configured' => !empty(config('services.twilio.sid')) &&
                          !empty(config('services.twilio.auth_token')),
            'from_number' => config('services.twilio.whatsapp_from')
        ]);
    }
}
