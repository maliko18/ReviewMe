<?php

namespace App\Services;

use App\Models\PlaceEvent;
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
                'search' => function ($query, $value) {
                    $query->where(function ($query) use ($value) {
                        $query->where('name', 'like', "%{$value}%")
                            ->orWhere('description', 'like', "%{$value}%")
                            ->orWhereHas('place', function ($query) use ($value) {
                                $query->where('name', 'like', "%{$value}%");
                            });
                    });
                },
                'date_range',
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
    public function storeEvent(array $data): PlaceEvent
    {
        return PlaceEvent::create($data);
    }

    /**
     * Update an existing place event.
     *
     * @param PlaceEvent $event
     * @param array $data
     * @return PlaceEvent
     */
    public function updateEvent(PlaceEvent $event, array $data): PlaceEvent
    {
        $event->update($data);
        return $event;
    }

    /**
     * Delete a place event.
     *
     * @param PlaceEvent $event
     * @return void
     */
    public function deleteEvent(PlaceEvent $event): void
    {
        $event->delete();
    }
}
