<?php

namespace App\Actions\Image;

use App\Models\Image;
use Tests\Fixtures\Model;

class AttachImagesToModel
{
    public function handle( Model $model, array $images):void
    {
        foreach ($images as $file) {
            $path = $file->store('images', 'public');
            Image::create([
                'path' => $path,
                'imageable_id' => $model->id,
                'imageable_type' => $model::class,
            ]);
        }
    }
}
