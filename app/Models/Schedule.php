<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function localities(): HasMany
    {
        return $this->hasMany(Locality::class);
    }

    public function journeyPatternSections(): HasMany
    {
        return $this->hasMany(JourneyPatternSection::class);
    }

    public function operators(): HasMany
    {
        return $this->hasMany(Operator::class);
    }

    public function routes(): HasMany
    {
        return $this->hasMany(Route::class);
    }

    public function routeSections(): HasMany
    {
        return $this->hasMany(RouteSection::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function stopPoints(): HasMany
    {
        return $this->hasMany(StopPoint::class);
    }

    public function vehicleJourneys(): HasMany
    {
        return $this->hasMany(VehicleJourney::class);
    }
}
