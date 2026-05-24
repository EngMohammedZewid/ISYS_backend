<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Partner extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        'image',
    ];

    public $translatedAttributes = ['name', 'bio', 'description'];

    protected $with = ['translations'];

    public function translations(): HasMany
    {
        return $this->hasMany(PartnerTranslation::class);
    }
}
