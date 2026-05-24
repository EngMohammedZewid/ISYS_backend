<?php

namespace App\Http\Services;

use App\Exceptions\ForgetCodeExpiredException;
use App\Exceptions\ForgetCodeNotMatchException;
use App\Exceptions\PasswordNotFoundException;
use App\Exceptions\PasswordNotMatchException;
use App\Exceptions\UserNotFoundException;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PasswordService
{
    public function __construct()
    {
        $this->user = new User();
    }

    public function changePassword(string $currentPassword, string $newPassword)
    {
        if (! auth()->user()->password) {
            throw new PasswordNotFoundException();
        }

        if (! Hash::check($currentPassword, auth()->user()->password)) {
            throw new PasswordNotMatchException();
        }

        return auth()->user()->update(['password' => Hash::make($newPassword)]);
    }

    public function forgetPassword(string $email)
    {
        $user = $this->getByEmail($email);

        if (! $user) {
            throw new UserNotFoundException();
        }
        $user->update([
            'forget_code' => $this->generateForgetCode(),
            'forget_code_expired_at' => Carbon::now()->addDays(1),
        ]);

        // Log::error($user);

        return $user;
    }

    private function getByEmail($email)
    {
        return $this->user->where('email', strtolower($email))->first();
    }

    private function generateForgetCode()
    {
        return now()->format('U').random_int(1000, 9999);
    }

    public function resetPassword(string $forgetCode, string $newPassword)
    {
        $user = $this->getByForgetCode($forgetCode);

        if ($forgetCode !== $user->forget_code) {
            throw new ForgetCodeNotMatchException();
        }

        if ($user->forgetCodeExpired()) {
            throw new ForgetCodeExpiredException();
        }

        return $user->update([
            'password' => Hash::make($newPassword),
            'forget_code' => $this->generateForgetCode(),
        ]);
    }

    private function getByForgetCode(string $forgetCode)
    {
        $user = $this->user->where('forget_code', $forgetCode)->first();

        if (! $user) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
