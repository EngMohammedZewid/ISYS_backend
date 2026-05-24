<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {

        $sessions = Session::whereHas('users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })->with('track.translations')->with('users')->get();

        return view('Qrcode', [
            'user' => $user,
            'sessions' => $sessions,
        ]);
    }

    public function qrcode()
    {
        return view('scan');
    }

    public function qrLogin(Request $request)
    {
        // Assume the QR code data is submitted as a base64 encoded string
        $qrCodeData = $request->input('qr_code_data');
        // $decodedData = base64_decode($qrCodeData);

        // Find user by QR code data (adjust as needed to match your QR code generation logic)
        // $user = User::where('qrcode', $decodedData)->first();
        $user = User::where('qrcode', $qrCodeData)->first();

        if (! $user) {
            return redirect()->route('login-web')->with('error', 'Invalid QR code');
        }

        // Log the user in
        auth()->login($user);

        // Redirect to a protected page
        return redirect()->to('users/'.$user->id);
    }
}
