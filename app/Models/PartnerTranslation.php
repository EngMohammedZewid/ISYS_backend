<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartnerTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'bio', 'description', 'locale'];

    public function partners(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }
}
