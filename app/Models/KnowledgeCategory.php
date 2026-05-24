<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KnowledgeCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    public function items(): HasMany
    {
        return $this->hasMany(KnowledgeItem::class);
    }
}
