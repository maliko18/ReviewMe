<!-- resources/js/Components/RestaurantCard.vue -->
<template>
    <Link
        :href="route('places.show', { place:1})"
        class="min-w-[300px] group"
    >
        <div class="relative h-48 rounded-lg overflow-hidden mb-3">
            <img
                :src="restaurant.image"
                :alt="restaurant.name"
                class="w-full h-full object-cover transition-transform group-hover:scale-110"
            />
            <div
                v-if="restaurant.discount"
                class="absolute bottom-2 left-2 bg-black px-2 py-1 text-xs text-white"
            >
                Jusqu'à -{{ restaurant.discount }}%
            </div>
        </div>

        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs text-gray-600 mb-1">{{ restaurant.cuisine }}</div>
                <h3 class="font-semibold group-hover:text-teal-600">{{ restaurant.name }}</h3>
                <div class="text-sm text-gray-600">
                    Prix moyen · {{ restaurant.price }}€
                </div>
            </div>
            <div class="text-lg font-bold">{{ restaurant.rating }}</div>
        </div>
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    restaurant: {
        type: Object,
        required: true
    }
})
</script>
