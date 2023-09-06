<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayoverPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'duration',
        'location_id',
    ];
}
