<?php

namespace App\Http\Controllers\API\Auth;

use App\Common\Enums\Message;
use App\Common\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Services\PasswordService;
use App\Mail\ForgetPasswordMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class PasswordController extends Controller
{
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function change(ChangePasswordRequest $request): JsonResponse
    {
        auth()->user()->changePassword($request->current_password, $request->new_password);

        return $this->response->success([], Message::PASSWORD_CHANGED);
    }

    public function forget(ForgetPasswordRequest $request): JsonResponse
    {
        $this->passwordService = new PasswordService();
        $user = $this->passwordService->forgetPassword($request->email);
        Mail::to($user->email)->send(new ForgetPasswordMail($user));

        return response()->json([
            'status' => 'success',
            'message' => Message::EMAIL_SENT_WITH_FORGET_CODE,
        ]);
    }

    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        $this->passwordService = new PasswordService();
        $this->passwordService->resetPassword($request->forget_code, $request->new_password);

        return $this->response->success();
    }
}
