<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StopPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'common_name',
        'atco_code',
        'locality_reference',
        'stop_type',
        'timing_status',
        'administrative_area_ref',
        'notes',
        'schedule_id',
        'location_id',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
