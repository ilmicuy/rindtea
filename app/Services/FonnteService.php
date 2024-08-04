<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FonnteService
{
    protected $baseUrl = 'https://api.fonnte.com/send';
    protected $token;

    public function __construct()
    {
        // Set your authorization token here
        $this->token = env("FONNTE_API_KEY");
    }

    /**
     * Send a message using Fonnte API.
     *
     * @param string $target
     * @param string $message
     * @return array
     */
    public function sendMessage(string $target, string $message)
    {
        $response = Http::withHeaders([
            'Authorization' => $this->token,
        ])->asMultipart()->post($this->baseUrl, [
            'target' => $target,
            'message' => $message,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => true,
            'message' => $response->body(),
        ];
    }
}
