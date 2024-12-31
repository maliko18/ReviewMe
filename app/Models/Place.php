<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Place extends Model
{
    /** @use HasFactory<\Database\Factories\PlaceFactory> */
    use HasFactory;
    protected $fillable = ['name', 'description', 'slug'];


    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function addBanners(): HasMany
    {
        return $this->hasMany(AdBanner::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function placeEvents(): HasMany
    {
        return $this->hasMany(PlaceEvent::class);
    }
    public function adBanners(): HasMany
    {
        return $this->hasMany(AdBanner::class);
    }


}
