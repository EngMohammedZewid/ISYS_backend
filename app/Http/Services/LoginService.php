<?php

namespace App\Http\Services;

use App\Exceptions\CredentialsNotCorrectException;
use App\Exceptions\EmailNotVerifiedException;
use App\Mail\EmailVerificationMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class LoginService
{
    public static function authenticate(array $data): User
    {
        if (! auth()->attempt([
            'email' => strtolower($data['email']),
            'password' => $data['password'],
        ])) {
            throw new CredentialsNotCorrectException();
        }

        $user = User::where('email', $data['email'])->first();

        if (! $user->hasVerifiedEmail()) {
            $emailCode = static::generateEmailCode();
            Mail::to($user->email)->send(new EmailVerificationMail($user, $emailCode));
            throw new EmailNotVerifiedException();
        }

        return auth()->user();
    }

    public static function generateEmailCode(): string
    {
        if (! app()->environment('production')) {
            return 1111;
        }

        return sprintf('%04d', mt_rand(1000, 9999));
    }
}
