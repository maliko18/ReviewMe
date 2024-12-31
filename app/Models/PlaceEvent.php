<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceEvent extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'start_date', 'end_date', 'meta', 'place_id'];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function meta()
    {
        return $this->json('meta');
    }
}
