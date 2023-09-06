<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JourneyPatternSection extends Model
{
    use HasFactory;

    public function journeyPatternTimingLinks(): HasMany
    {
        return $this->hasMany(JourneyPatternTimingLink::class);
    }
}
