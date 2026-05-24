<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        'url',
        'image',
    ];

    public $translatedAttributes = ['title'];

    protected $with = ['translations'];

    public function translations(): HasMany
    {
        return $this->hasMany(MenuTranslation::class);
    }
}
