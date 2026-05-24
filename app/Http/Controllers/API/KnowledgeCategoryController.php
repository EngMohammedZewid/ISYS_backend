<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\KnowledgeCategoryResource;
use App\Http\Resources\KnowledgeItemResource;
use App\Models\KnowledgeCategory;

class KnowledgeCategoryController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => KnowledgeCategoryResource::collection(KnowledgeCategory::all()),
        ]);
    }

    public function show(KnowledgeCategory $knowledgeCategory)
    {
        return response()->json([
            'status' => 'success',
            'data' => KnowledgeItemResource::collection($knowledgeCategory->items()->get()),
        ]);
    }
}
