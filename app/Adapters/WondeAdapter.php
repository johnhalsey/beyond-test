<?php

namespace App\Adapters;

use Illuminate\Support\Facades\Http;

class WondeAdapter
{
    private $apiKey;
    private $baseUrl;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->setApiKey();
        $this->baseUrl();
    }

    private function setApiKey()
    {
        $this->apiKey = config('services.wonde.api_key');
    }

    private function baseUrl()
    {
        $this->baseUrl = 'https://api.wonde.com/v1.0/schools/' . config('services.wonde.school_id') . '/';
    }

    public function get($url, $params = [])
    {
        return Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get($this->baseUrl . $url, $params)
            ->throw();
    }
}
