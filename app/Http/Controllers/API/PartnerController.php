<?php

namespace App\Http\Controllers\API;

use App\Common\Enums\Pagination;
use App\Http\Controllers\Controller;
use App\Http\Resources\PartnerResource;
use App\Models\Partner;

class PartnerController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => PartnerResource::collection(Partner::all()),
        ]);
    }
}
