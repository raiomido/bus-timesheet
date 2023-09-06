<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_code',
        'private_code',
        'start_date',
        'end_date',
        'operating_period',
        'bank_holiday_days_of_operation',
        'bank_holiday_days_of_non_operation',
        'registered_operator_ref',
        'mode',
        'standard_service_origin',
        'standard_service_destination',
    ];

    public function journeyPatterns() : BelongsToMany
    {
        return $this->belongsToMany(JourneyPattern::class);
    }

    public function lines() : BelongsToMany
    {
        return $this->belongsToMany(Line::class);
    }
}
