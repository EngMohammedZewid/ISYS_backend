<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'company_name',
        'subject',
        'services',
        'message',
        'site_url',
    ];
}
