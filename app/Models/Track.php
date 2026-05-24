<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Filament\Forms\Components\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Track extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        'is_active',
    ];

    public $translatedAttributes = ['title'];

    protected $with = ['translations'];

    /**
     * @return HasMany<Session, SessionTranslation>
     */
    public function translations(): HasMany
    {
        return $this->hasMany(TrackTranslation::class);
    }

    /**
     * @return HasMany<Session, Track>
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    /**
     * Scope a query to only include active Track.
     *
     * @method static \Illuminate\Database\Eloquent\Builder|Track active()
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query): Builder
    {
        return $query->where('is_active', true);
    }
}
