<?php

namespace App\Models;

use Database\Factories\CityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    /** @use HasFactory<CityFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    /*    'slug',*/
        'country_id'
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
