<?php

namespace App\Services;

use GuzzleHttp\Client;

class OpenAIService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('openai.api_key');
    }

    public function generateResponse($prompt)
    {
        $response = $this->client->post('https://api.openai.com/v1/engines/davinci-codex/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'prompt' => $prompt,
                'max_tokens' => 150,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        return $data['choices'][0]['text'] ?? 'No response from OpenAI';
    }
}
