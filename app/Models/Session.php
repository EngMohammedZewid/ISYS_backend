<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Session extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        'from',
        'to',
        'live_link',
        'link',
        'image',
        'speaker',
        'speaker_job_title',
        'date',
        'is_active',
    ];

    public $translatedAttributes = ['title', 'description'];

    protected $with = ['translations'];

    /**
     * @return HasMany<Session, SessionTranslation>
     */
    public function translations(): HasMany
    {
        return $this->hasMany(SessionTranslation::class);
    }

    /**
     * @return BelongsTo<Track, Session>
     */
    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }

    /**
     * @return BelongsToMany<User, Session>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'session_users');
    }

    /**
     * Scope a query to only include active Session.
     *
     * @method static \Illuminate\Database\Eloquent\Builder|Session active()
     */
    public function scopeActive($query): Builder
    {
        return $query->where('is_active', true);
    }
}
