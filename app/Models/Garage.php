<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'location_id'
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
