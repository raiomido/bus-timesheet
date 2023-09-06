<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference'
    ];

    public function routeLinks(): HasMany
    {
        return $this->hasMany(RouteLink::class);
    }
}
