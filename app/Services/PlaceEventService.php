<?php

namespace App\Services;

use App\Http\Requests\PlaceEvent\StorePlaceEventRequest;
use App\Http\Requests\PlaceEvent\UpdatePlaceEventRequest;
use App\Models\PlaceEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\QueryBuilder;

class PlaceEventService
{
    /**
     * Fetch events with filters, sorting, and pagination.
     *
     * @return mixed
     */
    public function getFilteredEvents()
    {
        return QueryBuilder::for(PlaceEvent::class)
            ->allowedFilters([
                'place_id',
                'status',
            ])
            ->allowedSorts(['start_date', 'end_date', 'created_at'])
            ->defaultSort('-start_date')
            ->with(['place'])
            ->paginate()
            ->withQueryString();
    }

    /**
     * Store a new place event.
     *
     * @param array $data
     * @return PlaceEvent
     */
    public function storeEvent(StorePlaceEventRequest $request): PlaceEvent
    {
        return DB::transaction(function () use ($request) {
            $event = PlaceEvent::create($request->validated());
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('events', 'public');
                    $event->images()->create([
                        'path' => $path,
                      /*  'meta' => [
                            'original_name' => $image->getClientOriginalName(),
                            'size' => $image->getSize(),
                            'mime' => $image->getMimeType()
                        ]*/
                    ]);
                }
            }
            return $event;
        });
    }

    public function updateEvent(PlaceEvent $event, UpdatePlaceEventRequest $request): PlaceEvent
    {
        return DB::transaction(function () use ($event, $request) {
            $validated = $request->validated();
            $event->update($validated);

            if (!empty($validated['deleted_images'])) {
                $deletedImages = $event->images()->whereIn('id', $validated['deleted_images'])->get();

                foreach ($deletedImages as $image) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                }
            }

            // Handle new images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('events', 'public');
                    $event->images()->create([
                        'path' => $path,
                       /* 'meta' => [
                            'original_name' => $image->getClientOriginalName(),
                            'size' => $image->getSize(),
                            'mime' => $image->getMimeType()
                        ]*/
                    ]);
                }
            }
            return $event;
        });
    }

    /**
     * Delete a place event.
     *
     * @param PlaceEvent $event
     * @return bool
     */

    public function deleteEvent(PlaceEvent $event):bool
    {
        return $event->delete();
    }
}
