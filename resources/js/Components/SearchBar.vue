<template>
    <form @submit.prevent="handleSearch" class="flex">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <MapPinIcon class="w-5 h-5 text-gray-400" />
            </div>
            <input
                v-model="location"
                type="text"
                class="w-full pl-10 pr-4 py-3 bg-white rounded-l-lg border-0 focus:ring-2 focus:ring-teal-500"
                placeholder="Paris"
            />
        </div>

        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <SearchIcon class="w-5 h-5 text-gray-400" />
            </div>
            <input
                v-model="query"
                type="text"
                class="w-full pl-10 pr-4 py-3 bg-white border-l border-gray-200 focus:ring-2 focus:ring-teal-500"
                placeholder="Cuisine, nom de restaurant..."
            />
        </div>

        <button
            type="submit"
            class="px-8 py-3 bg-teal-600 text-white font-medium rounded-r-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
        >
            RECHERCHE
        </button>
    </form>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { MapPinIcon, SearchIcon } from 'lucide-vue-next'

const location = ref('Paris')
const query = ref('')

const handleSearch = () => {
    router.visit(route('places.index'), {
        data: {
            location: location.value,
            query: query.value
        }
    })
}
</script>
