<?php

namespace App\Http\Controllers\API;

use App\Common\Enums\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsRequest;
use App\Http\Services\ContactUsService;

class ContactUsController extends Controller
{
    public function create(ContactUsRequest $request)
    {
        $user = $request->user();

        ContactUsService::sendContactUs($request->validated(), $user);

        return response()->json([
            'status' => 'success',
            'message' => Message::CONTACT_TO_US_IS_SENT,
        ]);
    }
}
