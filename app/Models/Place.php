<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Place extends Model
{
    /** @use HasFactory<\Database\Factories\PlaceFactory> */
    use HasFactory;
    protected $fillable = ['name', 'description', 'address', 'phone', 'email', 'website', 'facebook', 'instagram', 'twitter', 'linkedin', 'youtube', 'pinterest', 'tiktok', 'snapchat', 'whatsapp', 'telegram', 'viber', 'wechat', 'line', 'skype', 'whatsapp_business', 'google_map', 'latitude', 'longitude', 'status', 'user_id'];


    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function addBanners(): HasMany
    {
        return $this->hasMany(AddBanner::class);
    }

    public function placeEvents(): HasMany
    {
        return $this->hasMany(PlaceEvent::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

}
