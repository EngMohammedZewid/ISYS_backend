<?php

namespace App\Http\Controllers\API;

use App\Common\Enums\Pagination;
use App\Http\Controllers\Controller;
use App\Http\Resources\NewsCollection;
use App\Http\Resources\NewsResource;
use App\Models\News;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => NewsResource::collection(News::all()),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return response()->json([
            'status' => 'success',
            'data' => new NewsResource($news),
        ]);
    }
}
