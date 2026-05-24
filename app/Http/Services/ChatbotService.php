<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ChatbotService
{
    protected string $apiKey;
    protected string $serviceUrl;
    protected string $agentId;

    public function __construct()
    {
        $this->apiKey = config('watsonx.api_key');
        $this->serviceUrl = rtrim(config('watsonx.service_url'), '/');
        $this->agentId = config('watsonx.agent_id');
    }

    public function sendMessage(string $message, ?string $threadId = null): array
    {
        $token = $this->getIamToken();

        $request = Http::withToken($token)->timeout(60);

        if ($threadId) {
            $request = $request->withHeaders(['X-IBM-THREAD-ID' => $threadId]);
        }

        $response = $request->post(
            "{$this->serviceUrl}/v1/orchestrate/{$this->agentId}/chat/completions",
            [
                'messages' => [
                    ['role' => 'user', 'content' => $message],
                ],
                'stream' => false,
            ]
        );

        if ($response->failed()) {
            throw new \RuntimeException('Failed to send message to watsonx Orchestrate: ' . $response->body());
        }

        $data = $response->json();

        return [
            'thread_id' => $data['thread_id'] ?? null,
            'response' => $data['choices'][0]['message']['content'] ?? '',
            'model' => $data['model'] ?? null,
        ];
    }

    protected function getIamToken(): string
    {
        return Cache::remember('watsonx_iam_token', 3500, function () {
            $response = Http::asForm()->post('https://iam.cloud.ibm.com/identity/token', [
                'grant_type' => 'urn:ibm:params:oauth:grant-type:apikey',
                'apikey' => $this->apiKey,
            ]);

            if ($response->failed()) {
                // Fallback to MCSP token endpoint for watsonx Orchestrate
                $response = Http::withHeaders(['Content-Type' => 'application/json'])
                    ->post('https://iam.platform.saas.ibm.com/siusermgr/api/1.0/apikeys/token', [
                        'apikey' => $this->apiKey,
                    ]);
            }

            if ($response->failed()) {
                throw new \RuntimeException('Failed to get IBM IAM token: ' . $response->body());
            }

            return $response->json('access_token');
        });
    }
}
