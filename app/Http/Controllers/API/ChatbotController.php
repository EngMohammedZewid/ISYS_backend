<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChatbotRequest;
use App\Http\Services\ChatbotService;

class ChatbotController extends Controller
{
    protected ChatbotService $chatbotService;

    public function __construct(ChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    public function chat(ChatbotRequest $request)
    {
        $result = $this->chatbotService->sendMessage(
            $request->input('message'),
            $request->input('thread_id')
        );

        return response()->json([
            'status' => 'success',
            'thread_id' => $result['thread_id'],
            'response' => $result['response'],
        ]);
    }
}
