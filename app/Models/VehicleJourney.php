<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleJourney extends Model
{
    use HasFactory;

    protected $fillable = [
        'private_code',
        'operating_period',
        'bank_holiday_days_of_operation',
        'bank_holiday_days_of_non_operation',
        'garage_ref',
        'vehicle_journey_code',
        'service_ref',
        'line_ref',
        'journey_pattern_ref',
        'departure_time',
        'layover_point_id',
        'ticket_machine_id',
    ];

    public function layoutOvers(): BelongsTo
    {
        return $this->belongsTo(LayoverPoint::class);
    }

    public function ticketMachine(): BelongsTo
    {
        return $this->belongsTo(TicketMachine::class);
    }
}
