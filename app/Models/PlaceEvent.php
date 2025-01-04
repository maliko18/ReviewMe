<?php

namespace App\Models;

use Database\Factories\PlaceEventFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PlaceEvent extends Model
{
    /** @use HasFactory<PlaceEventFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description', 'start_date', 'end_date',  /*'status',*/
        'place_id'];


    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
