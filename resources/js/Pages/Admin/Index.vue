<!-- resources/js/Pages/Admin/Dashboard.vue -->
<template>
    <AdminLayout>
        <div class="grid grid-cols-3 gap-6">
            <!-- Places Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-gray-500 text-sm">Total Places</h3>
                    <BuildingIcon class="w-8 h-8 text-teal-500" />
                </div>
                <p class="text-3xl font-bold mt-2">{{ stats.places_count }}</p>
            </div>

            <!-- Reviews Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-gray-500 text-sm">Total Reviews</h3>
                    <StarIcon class="w-8 h-8 text-yellow-500" />
                </div>
                <p class="text-3xl font-bold mt-2">{{ stats.reviews_count }}</p>
            </div>

            <!-- Countries Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-gray-500 text-sm">Countries</h3>
                    <GlobeIcon class="w-8 h-8 text-blue-500" />
                </div>
                <p class="text-3xl font-bold mt-2">{{ stats.countries_count }}</p>
            </div>

            <!-- Categories Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-gray-500 text-sm">Categories</h3>
                    <TagsIcon class="w-8 h-8 text-purple-500" />
                </div>
                <p class="text-3xl font-bold mt-2">{{ stats.categories_count }}</p>
            </div>

            <!-- Events Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-gray-500 text-sm">Events</h3>
                    <CalendarIcon class="w-8 h-8 text-red-500" />
                </div>
                <p class="text-3xl font-bold mt-2">{{ stats.events_count }}</p>
            </div>

            <!-- Ad Banners Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-gray-500 text-sm">Ad Banners</h3>
                    <ImageIcon class="w-8 h-8 text-green-500" />
                </div>
                <p class="text-3xl font-bold mt-2">{{ stats.banners_count }}</p>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import {
    BuildingIcon,
    StarIcon,
    GlobeIcon,
    TagsIcon,
    CalendarIcon,
    ImageIcon
} from 'lucide-vue-next'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineProps({
    stats: {
        type: Object,
        required: true
    }
})
</script>
