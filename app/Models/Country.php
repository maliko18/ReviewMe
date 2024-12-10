<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    /** @use HasFactory<\Database\Factories\CountryFactory> */
    use HasFactory;

    protected function meta(): Attribute
    {
        return Attribute::make(
            get: fn ( $value) => json_decode($value),
        );
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
