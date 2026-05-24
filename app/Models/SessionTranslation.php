<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'locale'];

    /**
     * @return BelongsTo<Session, SessionTranslation>
     */
    public function sessions(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }
}
