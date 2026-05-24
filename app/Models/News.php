<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class News extends Model
{
    use HasFactory, Translatable;

    protected $table = 'news';

    protected $fillable = [
        'image',
        'featured',
    ];

    public $translatedAttributes = ['title', 'description'];

    protected $with = ['translations'];

    public function translations(): HasMany
    {
        return $this->hasMany(NewsTranslation::class);
    }
}
