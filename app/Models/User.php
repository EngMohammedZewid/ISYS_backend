<?php

namespace App\Models;

use App\Exceptions\PasswordNotFoundException;
use App\Exceptions\PasswordNotMatchException;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'phone_number',
        'job_title',
        'company_name',
        'admin_promoted',
        'email_code',
        'forget_code',
        'forget_code_expired_at',
        'type',
        'email_verified_at',
        'qrcode'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function scopeIsAdminPromoted($query): Builder
    {
        return $query->where('admin_promoted', true);
    }

    public function forgetCodeExpired(): bool
    {
        return $this->forget_code_expired_at < now();
    }

    public function getToken(): string
    {
        return $this->createToken('token')->plainTextToken;
    }

    public function logout()
    {
        return $this->tokens()->delete();
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

    /**
     * @return BelongsToMany<Session, User>
     */
    public function sessions(): BelongsToMany
    {
        return $this->belongsToMany(Session::class, 'session_users');
    }

    public function knowledge_items(): BelongsToMany
    {
        return $this->belongsToMany(KnowledgeItem::class);
    }

    public function generateQrCode()
    {
        $qrCode = QrCode::format('png')
            ->size(250)
            ->generate($this->email);

        $this->qrcode = $qrCode; // Store the binary data directly
        $this->save();

        return $qrCode; // Optional: return the binary data for further use
    }
}
