<!-- resources/js/Components/RestaurantSection.vue -->
<template>
    <div class="mb-16">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold">{{ title }}</h2>
            <div class="flex items-center gap-4">
                <Link
                    :href="route('places.index')"
                    class="text-sm text-teal-600 hover:text-teal-700"
                >
                    VOIR PLUS
                </Link>
                <div class="flex gap-2">
                    <button
                        class="p-2 rounded-full hover:bg-gray-100"
                        @click="scroll('prev')"
                    >
                        <ChevronLeftIcon class="w-5 h-5" />
                    </button>
                    <button
                        class="p-2 rounded-full hover:bg-gray-100"
                        @click="scroll('next')"
                    >
                        <ChevronRightIcon class="w-5 h-5" />
                    </button>
                </div>
            </div>
        </div>

        <div class="relative">
            <div ref="container" class="flex gap-4 overflow-hidden">
                <RestaurantCard
                    v-for="restaurant in restaurants"
                    :key="restaurant.id"
                    :restaurant="restaurant"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { ChevronLeftIcon, ChevronRightIcon } from 'lucide-vue-next'
import RestaurantCard from './RestaurantCard.vue'

const props = defineProps({
    title: String,
    restaurants: Array
})

const container = ref(null)

const scroll = (direction) => {
    const scrollAmount = 400
    container.value.scrollLeft += direction === 'next' ? scrollAmount : -scrollAmount
}
</script>
