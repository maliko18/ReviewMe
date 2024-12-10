<?php

namespace App\Actions\Image;

use App\Models\Image;

class RemoveImagesWithIds
{
    public function handle(array $imageIds)
    {
        return Image::query()->whereIn('id', $imageIds)->delete();
    }
}
