<script setup>
import { Link } from '@inertiajs/vue3';
import { StarIcon, MapPinIcon, CalendarIcon } from 'lucide-react';

defineProps({
    place: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <!-- Image -->
        <div class="relative h-48">
            <img
                v-if="place.images[0]"
                :src="`/storage/${place.images[0].path}`"
                :alt="place.name"
                class="w-full h-full object-cover"
            />
            <div v-else class="w-full h-full bg-gray-100 flex items-center justify-center">
                <MapPinIcon class="w-12 h-12 text-gray-400" />
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">
                        <Link :href="route('admin.places.show', place.id)" class="hover:text-indigo-600">
                            {{ place.name }}
                        </Link>
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 line-clamp-2">
                        {{ place.description }}
                    </p>
                </div>
            </div>

            <!-- Categories -->
            <div class="mt-4 flex flex-wrap gap-2">
        <span
            v-for="category in place.categories"
            :key="category.id"
            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
        >
          {{ category.name }}
        </span>
            </div>

            <!-- Stats -->
            <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                <div class="flex items-center">
                    <StarIcon class="w-4 h-4 text-yellow-400 mr-1" />
                    {{ place.reviews_count || 0 }} Reviews
                </div>
                <div class="flex items-center">
                    <CalendarIcon class="w-4 h-4 text-blue-400 mr-1" />
                    {{ place.events_count || 0 }} Events
                </div>
            </div>

            <!-- Actions -->
            <div v-if="$page.props.can.edit_places" class="mt-4 flex justify-end space-x-2">
                <Link
                    :href="route('admin.places.edit', place.id)"
                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                >
                    Edit
                </Link>
            </div>
        </div>
    </div>
</template>
