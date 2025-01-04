<?php

namespace App\Models;

use Database\Factories\PlaceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Place extends Model
{
    /** @use HasFactory<PlaceFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description', 'slug'];

    public function addBanners(): HasMany
    {
        return $this->hasMany(AdBanner::class);
    }

    public function placeEvents(): HasMany
    {
        return $this->hasMany(PlaceEvent::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function adBanners(): HasMany
    {
        return $this->hasMany(AdBanner::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function isAdminBy(User $user): bool
    {
        return $user->hasRole('super-admin') ||
            $this->user_id === $user->id ||
            $this->users()->where('users.id', $user->id)->exists();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }


}
