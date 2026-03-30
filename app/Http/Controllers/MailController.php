<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\WhatsAppService;
use App\WhatsApp\MarketingMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class MailController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    public function index() {

        return view('mail.index' , [
            'clients' => Client::all(),
            'whatsapp_enabled' => $this->whatsappService->isEnabled(),
        ]);
    }

    public function send(Request $request) {
        $request->validate([
            'clients' => 'required|array',
            'clients.*' => 'exists:clients,id',
            'prompt' => 'nullable|string',
            'send_method' => 'required|in:email,whatsapp,both',
        ]);

        $clients = Client::find($request->clients);
        $project = \App\Models\Project::where('user_id', Auth::id())->first();
        $sendMethod = $request->send_method ?? 'email';

        // Get The Products Of The Clients If Have By Pibot Table
        if (!$clients) {
            return redirect()->back()->with('msg' , __('app.messages.add_clients'));
        }

        $emailResults = [];
        $whatsappResults = [];
        $emailCount = 0;
        $whatsappCount = 0;

        $clients->each(function($client) {
            $client->orders;
        });

        // Get An Marketing Email Content Depends On Every Client Products
        $clients->each(function($client) use ($project, $sendMethod, &$emailResults, &$whatsappResults, &$emailCount, &$whatsappCount, $request) {
            $content = $client->MarketingEmailContent($client , $request->prompt);

            // Send Email
            if ($sendMethod === 'email' || $sendMethod === 'both') {
                try {
                    if ($client->email) {
                        Mail::to($client->email)->send(new \App\Mail\MarketingMail($content, $project));
                        $emailResults[] = [
                            'client' => $client->name,
                            'email' => $client->email,
                            'status' => 'sent'
                        ];
                        $emailCount++;
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to send email to client', [
                        'client_id' => $client->id,
                        'email' => $client->email,
                        'error' => $e->getMessage()
                    ]);
                    $emailResults[] = [
                        'client' => $client->name,
                        'email' => $client->email,
                        'status' => 'failed',
                        'error' => $e->getMessage()
                    ];
                }
            }

            // Send WhatsApp
            if (($sendMethod === 'whatsapp' || $sendMethod === 'both') && $this->whatsappService->isEnabled()) {
                try {
                    if ($client->whatsapp_phone && $client->whatsapp_notifications) {
                        $whatsappMessage = new MarketingMessage($client->whatsapp_phone ?? $client->phone, [
                            'client' => $client,
                            'content' => strip_tags($content), // Remove HTML tags for WhatsApp
                            'subject' => __('whatsapp.marketing.default_subject')
                        ]);

                        $result = $whatsappMessage->send();

                        if ($result['success']) {
                            $whatsappResults[] = [
                                'client' => $client->name,
                                'phone' => $client->whatsapp_phone,
                                'status' => 'sent',
                                'message_sid' => $result['message_sid']
                            ];
                            $whatsappCount++;
                        } else {
                            $whatsappResults[] = [
                                'client' => $client->name,
                                'phone' => $client->whatsapp_phone,
                                'status' => 'failed',
                                'error' => $result['error']
                            ];
                        }

                        // Add delay to avoid rate limiting
                        usleep(500000); // 0.5 seconds
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to send WhatsApp message to client', [
                        'client_id' => $client->id,
                        'whatsapp_phone' => $client->whatsapp_phone,
                        'error' => $e->getMessage()
                    ]);
                    $whatsappResults[] = [
                        'client' => $client->name,
                        'phone' => $client->whatsapp_phone,
                        'status' => 'failed',
                        'error' => $e->getMessage()
                    ];
                }
            }
        });

        // Prepare success message
        $message = '';
        if ($sendMethod === 'email') {
            $message = __('app.messages.emails_send_count', ['count' => $emailCount]);
        } elseif ($sendMethod === 'whatsapp') {
            $message = __('app.messages.whatsapp_send_count', ['count' => $whatsappCount]);
        } else {
            $message = __('app.messages.messages_send_count', [
                'email_count' => $emailCount,
                'whatsapp_count' => $whatsappCount
            ]);
        }

        return redirect()->route('mail.index')->with([
            'msg' => $message,
            'email_results' => $emailResults,
            'whatsapp_results' => $whatsappResults,
            'send_method' => $sendMethod
        ]);
    }
}
