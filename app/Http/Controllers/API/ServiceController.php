<?php

namespace App\Http\Controllers\API;

use App\Common\Enums\Pagination;
use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceCollection;
use App\Http\Resources\ServiceResource;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $response = Service::orderBy('sort_number')->get();

        return response()->json([
            'status' => 'success',
            'data' => ServiceResource::collection($response),
        ]);
    }

    public function show(Service $service)
    {
        return response()->json([
            'status' => 'success',
            'data' => new ServiceResource($service),
        ]);
    }
}
