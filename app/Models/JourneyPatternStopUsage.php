<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JourneyPatternStopUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'sequence_number',
        'activity',
        'dynamic_destination_display',
        'stop_point_ref',
        'timing_status',
    ];
}
