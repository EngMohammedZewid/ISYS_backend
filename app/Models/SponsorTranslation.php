<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'locale'];

    public function sponsors(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }
}
