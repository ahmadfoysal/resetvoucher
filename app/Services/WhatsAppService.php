<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    private $baseUrl;
    private $instanceName;
    private $token;

    public function __construct()
    {
        $this->baseUrl = config('whatsapp.api_url');
        $this->instanceName = config('whatsapp.instance');
        $this->token = config('whatsapp.token'); // API Token if required
    }

    /**
     * Send WhatsApp Message
     */
    public function sendMessage($number, $message)
    {
        $url = "{$this->baseUrl}/api/{$this->instanceName}/send-message";

        $data = [
            'phone' => $number,
            'isGroup' => false,
            'isNewsletter' => false,
            'isLid' => false,
            'message' => $message,
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($url, $data);

            // Log response for debugging
            \Log::info('WPPConnect API Response:', ['body' => $response->body()]);

            return $response->json() ?? ['error' => 'Empty response from WPPConnect'];
        } catch (\Exception $e) {
            \Log::error('WPPConnect API Error:', ['message' => $e->getMessage()]);
            return ['error' => $e->getMessage()];
        }
    }


    /**
     * Send OTP via WhatsApp
     */
    public function sendOtp($number, $otp)
    {
        $message = "Your RemoteMikroTik OTP code is: $otp";
        return $this->sendMessage($number, $message);
    }

    /**
     * Get WhatsApp Instance Status
     */
    public function getInstanceStatus()
    {
        $url = "{$this->baseUrl}/status/{$this->instanceName}";
        $response = Http::get($url);
        return $response->json();
    }
}
