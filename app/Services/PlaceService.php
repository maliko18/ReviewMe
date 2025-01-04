<?php

namespace App\Services;

use App\Actions\Address\AttachAddressesToPlace;
use App\Actions\Image\AttachImagesToModel;
use App\Actions\Image\RemoveImagesWithIds;
use App\Actions\Place\GetAllPlaces;
use App\Actions\Place\GetPlace;
use App\Actions\Place\UpdateOrCreatePlace;
use App\Http\Requests\Place\PlaceRequest;
use App\Models\Place;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PlaceService
{
    public function lisPlaces(): Collection
    {
        return (new GetAllPlaces())->handle();
    }

    public function getPlace(Place $place): Place
    {
        return (new GetPlace())->handle($place);
    }

    public function getPlacesWithFilters(): LengthAwarePaginator
    {
        return QueryBuilder::for(Place::class)
            ->with(['images', 'categories', 'addresses.city.country'])
            ->withCount(['reviews', 'placeEvents'])
            ->allowedFilters([
                AllowedFilter::partial('name'),
                AllowedFilter::exact('categories.id'),
            ])
            ->allowedSorts(['created_at', 'name'])
            ->defaultSort('-created_at')
            ->paginate();
    }

    public function getPlaceDetails(Place $place)
    {
        return QueryBuilder::for(Place::where('id', $place->id))
            ->with(['images', 'categories', 'address.city.country', 'reviews.user'])
            ->firstOrFail();
    }

    public function loadPlaceForEdit(Place $place): Place
    {
        return $place->load(['images', 'categories', 'address.city.country']);
    }

    public function updatePlace(Place $place, PlaceRequest $request): void
    {
        DB::transaction(function () use ($place, $request) {
            $validated = $request->validated();
            $validated['slug'] = Str::slug($validated['name']);

            $place->update($validated);
            $place->categories()->sync($validated['categories']);

            if ($place->addresses->first()) {
                $place->addresses->first()->update($validated['address']);
            } else {
                $place->addresses()->create($validated['address']);
            }

            if (!empty($validated['deleted_images'])) {
                $place->images()->whereIn('id', $validated['deleted_images'])->delete();
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('places', 'public');
                    $place->images()->create(['path' => $path]);
                }
            }
        });

    }

    public function update(Place $place, array $data): Place
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

    public function storePlace(PlaceRequest $request): void
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();
            $validated['slug'] = Str::slug($validated['name']);
            $validated['user_id'] = auth()->id();

            $place = Place::create($validated);
            $place->users()->attach(auth()->id());
            $place->categories()->attach($validated['categories']);
            $place->address()->create($validated['address']);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('places', 'public');
                    $place->images()->create(['path' => $path]);
                }
            }
        });
    }

    public function deletePlace(Place $place): void
    {
        $place->delete();
    }

}
