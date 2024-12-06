<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceEvent extends Model
{
    /** @use HasFactory<\Database\Factories\PlaceEventFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description', 'start_date', 'end_date', 'start_time', 'end_time', 'status', 'place_id'];
}
