<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JourneyPattern extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'destination_display',
        'direction',
        'route_ref',
        'journey_pattern_section_refs',
    ];
}
