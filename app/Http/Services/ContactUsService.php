<?php

namespace App\Http\Services;

use App\Mail\ContactUSMail;
use App\Models\ContactUs;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ContactUsService
{
    public static function sendContactUs(array $data, User $user): ContactUs
    {
        $contactUS = ContactUs::create([
            'full_name' => $user->full_name,
            'email' => $user->email,
            'site_url' => $data['siteUrl'],
            'company_name' => $data['companyName'],
            'subject' => $data['reason'],
            'services' => $data['services'],
            'message' => $data['message'],
        ]);
        Mail::to($contactUS->email)->send(new ContactUSMail($contactUS));

        return $contactUS;
    }
}
