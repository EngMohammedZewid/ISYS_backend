<?php

namespace App\Http\Controllers\API\Auth;

use App\Common\Enums\Message;
use App\Http\Requests\VerifyEmailRequest;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Routing\Controller;

class VerifyEmailController extends Controller
{
    public function verify(VerifyEmailRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'status' => 'error',
                'message' => Message::EMAIL_ALREADY_VERIFIED,
            ], 400);
        }

        if ($user->email_code != $request->emailCode) {
            return response()->json([
                'status' => 'error',
                'message' => Message::INVALID_EMAIL_VERIFICATION,
            ], 400);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json([
            'status' => 'success',
            'message' => Message::EMAIL_IS_VERIFIED,
        ]);
    }
}
