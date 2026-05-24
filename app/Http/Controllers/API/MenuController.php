<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $response = Menu::all();

        return response()->json([
            'status' => 'success',
            'data' => MenuResource::collection($response),
        ]);
    }
}
