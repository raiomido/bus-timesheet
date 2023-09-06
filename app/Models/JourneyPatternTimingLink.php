<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JourneyPatternTimingLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'journey_pattern_section_id',
        'from_id',
        'to_id',
        'route_link_ref',
        'run_time',
    ];

    public function from(): BelongsTo
    {
        return $this->belongsTo(JourneyPatternStopUsage::class);
    }

    public function to(): BelongsTo
    {
        return $this->belongsTo(JourneyPatternStopUsage::class);
    }
}
