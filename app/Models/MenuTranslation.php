<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'locale'];

    public function menus(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}
