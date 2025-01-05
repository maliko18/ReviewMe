<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    /** @use HasFactory<\Database\Factories\ImageFactory> */
    use HasFactory;

    protected $fillable = ['path','meta', 'imageable_id', 'imageable_type'];

    protected function path(): Attribute
    {
        return Attribute::make(
            get: fn ( $value) =>str_contains($value, 'http')?$value: Storage::url($value),
        );
    }

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
