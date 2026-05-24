<?php

namespace App\Http\Services;

use App\Mail\EmailVerificationMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterService
{
    public static function register(array $data): User
    {
        $user = User::IsAdminPromoted()->where('email', $data['email'])->first();

        if ($user) {
            if (! $user->hasVerifiedEmail()) {
                $user->update([
                    'email' => $data['email'],
                    'phone_number' => $data['phoneNumber'],
                    'password' => Hash::make($data['password']),
                    'full_name' => $data['fullName'],
                    'job_title' => $data['jobTitle'],
                    'company_name' => $data['companyName'],
                    'type' => $data['type'],
                ]);
                $user->markEmailAsVerified();
            } else {
                // User already exists and is verified, no need to update
                return $user;
            }
        } else {
            $emailCode = static::generateEmailCode();
            $user = User::create([
                'email' => $data['email'],
                'phone_number' => $data['phoneNumber'],
                'password' => Hash::make($data['password']),
                'full_name' => $data['fullName'],
                'job_title' => $data['jobTitle'],
                'company_name' => $data['companyName'],
                'company_name' => $data['companyName'],
                'email_code' => $emailCode,
                'type' => $data['type'],
            ]);
            Mail::to($user->email)->send(new EmailVerificationMail($user, $emailCode));
        }

        return $user;
    }

    public static function generateEmailCode(): string
    {
        if (! app()->environment('production')) {
            return 1111;
        }

        return sprintf('%04d', mt_rand(1000, 9999));
    }
}
