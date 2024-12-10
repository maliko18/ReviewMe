<?php

namespace App\Services;

use App\Actions\Address\AttachAddressesToPlace;
use App\Actions\Image\AttachImagesToModel;
use App\Actions\Image\RemoveImagesWithIds;
use App\Actions\Place\GetAllPlaces;
use App\Actions\Place\GetPlace;
use App\Actions\Place\UpdateOrCreatePlace;
use App\Models\Place;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PlaceService
{
    public function create(array $data): Place
    {
        return DB::transaction(function () use ($data) {
            $place = (new UpdateOrCreatePlace())->handle($this->$data);

            if (isset($data['images'])) {
                (new AttachImagesToModel())->handle($place, $data['images']);
            }

            if (isset($data['address'])) {
                (new AttachAddressesToPlace())->handle($place, $data['address']);
            }
        });
    }

    public function update(Place $place, array $data):Place
    {
        return DB::transaction(function () use ($place, $data) {
            $place = (new UpdateOrCreatePlace())->handle($this->$data);
            if (isset($data['remove_image_ids'])) {
                (new RemoveImagesWithIds())->handle($data['remove_image_ids']);
            }
            if (isset($data['images'])) {
                (new AttachImagesToModel())->handle($place, $data['images']);
            }

            if (isset($data['address'])) {
                $place->addresses()->delete();
                (new AttachAddressesToPlace())->handle($place, $data['address']);
            }
            return $place;
        });

    }

    public function delete(Place $place): bool
    {
        return $place->delete();
    }

    public function lisPlaces(): Collection
    {
        return (new GetAllPlaces())->handle();
    }

    public function getPlace(Place $place): Place
    {
        return (new GetPlace())->handle($place);
    }

}
