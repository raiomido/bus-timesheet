<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Operator extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'reference',
        'national_code',
        'code',
        'short_name',
        'name_on_licence',
        'licence_number',
        'licence_classification',
    ];

    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(Address::class);
    }

    public function garages(): BelongsToMany
    {
        return $this->belongsToMany(Garage::class);
    }

}
