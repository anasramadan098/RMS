<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class WhatsAppSettingsController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    /**
     * Show WhatsApp settings page
     */
    public function index()
    {
        $totalClients = Client::count();
        $whatsappClients = Client::whereNotNull('whatsapp_phone')->count();
        $enabledClients = Client::where('whatsapp_notifications', true)
                               ->whereNotNull('whatsapp_phone')
                               ->count();
        
        // You can add message count from logs or database if you track them
        $messagesSent = 0; // Placeholder for now

        return view('whatsapp.settings', compact(
            'totalClients',
            'whatsappClients', 
            'enabledClients',
            'messagesSent'
        ));
    }

    /**
     * Save WhatsApp settings
     */
    public function save(Request $request)
    {
        $request->validate([
            'twilio_sid' => 'required|string',
            'twilio_token' => 'required|string',
            'whatsapp_from' => 'required|string',
            'whatsapp_enabled' => 'nullable|boolean'
        ]);

        try {
            // Update .env file
            $this->updateEnvFile([
                'TWILIO_SID' => $request->twilio_sid,
                'TWILIO_AUTH_TOKEN' => $request->twilio_token,
                'TWILIO_WHATSAPP_FROM' => $request->whatsapp_from,
                'WHATSAPP_ENABLED' => $request->whatsapp_enabled ? 'true' : 'false'
            ]);

            // Clear config cache to reload new values
            Artisan::call('config:clear');

            return redirect()->route('whatsapp.settings')
                           ->with('success', __('whatsapp.settings.settings_saved'));

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', __('app.error') . ': ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Update .env file with new values
     */
    private function updateEnvFile(array $data)
    {
        $envFile = base_path('.env');
        $envContent = File::get($envFile);

        foreach ($data as $key => $value) {
            // Escape special characters in value
            $value = addslashes($value);
            
            // Check if key exists in .env file
            if (preg_match("/^{$key}=.*$/m", $envContent)) {
                // Update existing key
                $envContent = preg_replace(
                    "/^{$key}=.*$/m",
                    "{$key}={$value}",
                    $envContent
                );
            } else {
                // Add new key at the end
                $envContent .= "\n{$key}={$value}";
            }
        }

        File::put($envFile, $envContent);
    }

    /**
     * Test WhatsApp connection
     */
    public function testConnection(Request $request)
    {
        $request->validate([
            'phone' => 'required|string'
        ]);

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

    /**
     * Show WhatsApp templates page
     */
    public function templates()
    {
        return view('whatsapp.templates');
    }

    /**
     * Show WhatsApp logs page
     */
    public function logs()
    {
        // You can implement log viewing functionality here
        return view('whatsapp.logs');
    }
}
