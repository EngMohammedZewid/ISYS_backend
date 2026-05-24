<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\InterestRequest;
use App\Models\KnowledgeItem;

class KnowledgeItemController extends Controller
{
    public function interest(KnowledgeItem $KnowledgeItem, InterestRequest $request)
    {
        $KnowledgeItem->users()->attach($request->user()->id, [
            'reason' => $request->validated('why_interested'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
        ]);
    }
}
