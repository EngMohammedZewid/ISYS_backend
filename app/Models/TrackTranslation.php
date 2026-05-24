<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'locale'];

    /**
     * @return BelongsTo<Track, TrackTranslation>
     */
    public function tracks(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }
}
