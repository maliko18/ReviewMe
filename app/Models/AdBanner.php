<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdBanner extends Model
{
    /** @use HasFactory<\Database\Factories\AdBannerFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'start_date',
        'end_date',
        'place_id'
    ];
}
