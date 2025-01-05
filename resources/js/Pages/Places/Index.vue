<!-- resources/js/Pages/Place/Index.vue -->
<template>

    <Head :title="'Best Restaurants in ' + location" />

    <MainLayout>
        <template #breadcrumb>
            <li class="text-gray-700">Restaurants in {{ location }}</li>
        </template>

        <div class="flex gap-6">
            <!-- Places List -->
            <div class="w-2/3 space-y-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold">
                        Les {{ places.length }} meilleurs restaurants à {{ location }}
                    </h1>
                    <div class="flex items-center gap-4">
                        <button class="flex items-center gap-2 text-sm" @click="toggleFilters">
                            <SlidersIcon class="w-4 h-4" />
                            Filtres
                        </button>
                        <select
                            v-model="sortBy"
                            class="text-sm border-gray-300 rounded-md focus:border-teal-500 focus:ring-teal-500"
                        >
                            <option value="rating">Meilleure note</option>
                            <option value="price_asc">Prix croissant</option>
                            <option value="price_desc">Prix décroissant</option>
                        </select>
                    </div>
                </div>

                <!-- Place Cards -->
                <div class="space-y-4">
                    <div
                        v-for="place in paginatedPlaces"
                        :key="place.id"
                        class="bg-white rounded-lg shadow-sm overflow-hidden"
                    >
                        <div class="flex">
                            <!-- Images Carousel -->
                            <div class="relative w-72 h-48">
                                <button
                                    v-if="place.images.length > 1"
                                    class="absolute left-2 inset-y-0 text-white"
                                    @click="previousImage(place)"
                                >
                                    <ChevronLeftIcon class="w-6 h-6" />
                                </button>

                                <img
                                    :src="place.images[place.currentImageIndex].path"
                                    class="w-full h-full object-cover"
                                    :alt="place.name"
                                />

                                <button
                                    v-if="place.images.length > 1"
                                    class="absolute right-2 inset-y-0 text-white"
                                    @click="nextImage(place)"
                                >
                                    <ChevronRightIcon class="w-6 h-6" />
                                </button>

                                <!-- Image Dots -->
                                <div
                                    v-if="place.images.length > 1"
                                    class="absolute bottom-2 left-1/2 transform -translate-x-1/2 flex gap-1"
                                >
                                    <button
                                        v-for="(_, index) in place.images"
                                        :key="index"
                                        class="w-2 h-2 rounded-full"
                                        :class="index === place.currentImageIndex ? 'bg-white' : 'bg-white/50'"
                                        @click="place.currentImageIndex = index"
                                    />
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <Link
                                            :href="route('places.show', place.id)"
                                            class="text-xl font-semibold hover:text-teal-600"
                                        >
                                            {{ place.name }}
                                        </Link>
                                        <div class="flex items-center gap-4 mt-1 text-sm text-gray-600">
                                            <span>€ · {{ place.categories.map(c => c.name).join(', ') }}</span>
                                            <span>Prix moyen {{ place.average_price }}€</span>
                                        </div>
                                        <div class="mt-2">
                                            <div
                                                v-for="badge in place.badges"
                                                :key="badge"
                                                class="inline-flex items-center px-2 py-1 mr-2 rounded text-xs font-medium"
                                                :class="getBadgeClass(badge)"
                                            >
                                                {{ badge }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-end">
                                        <div class="text-xl font-bold">{{ place.rating }}/10</div>
                                        <div class="text-sm text-gray-500">
                                            {{ place.reviews_count }} avis
                                        </div>
                                    </div>
                                </div>

                                <p class="mt-3 text-gray-600 line-clamp-2">
                                    {{ place.description }}
                                </p>

                                <!-- Time Slots -->
                                <div class="mt-4">
                                    <div class="text-sm font-medium mb-2">Horaires disponibles:</div>
                                    <div class="flex gap-2">
                                        <button
                                            v-for="slot in place.available_slots"
                                            :key="slot"
                                            class="px-3 py-1 text-sm bg-teal-50 text-teal-700 rounded hover:bg-teal-100"
                                        >
                                            {{ slot }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="flex justify-center gap-2">
                    <button
                        v-for="n in totalPages"
                        :key="n"
                        class="w-8 h-8 rounded-full"
                        :class="currentPage === n ? 'bg-teal-600 text-white' : 'hover:bg-gray-100'"
                        @click="currentPage = n"
                    >
                        {{ n }}
                    </button>
                </div>
            </div>

            <!-- Map -->
            <div class="w-1/3">
                <div class="sticky top-4 bg-white rounded-lg shadow-sm p-4 h-[calc(100vh-6rem)]">
                    <!-- Carte Leaflet -->
                    <div id="map" class="w-full h-full bg-gray-100 rounded-lg"></div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import {
    SlidersIcon,
    ChevronLeftIcon,
    ChevronRightIcon
} from 'lucide-vue-next';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

const props = defineProps({
    places: {
        type: Array,
        required: true
    },
    location: {
        type: String,
        default: 'Paris'
    },
    filters: {
        type: Object,
        default: () => ({})
    }
});

// State
const sortBy = ref('rating');
const currentPage = ref(1);
const itemsPerPage = 10;
const map = ref(null);
const userPosition = ref(null);

// Computed
const sortedPlaces = computed(() => {
    let sorted = [...props.places];

    switch (sortBy.value) {
        case 'price_asc':
            return sorted.sort((a, b) => a.average_price - b.average_price);
        case 'price_desc':
            return sorted.sort((a, b) => b.average_price - a.average_price);
        default:
            return sorted.sort((a, b) => b.rating - a.rating);
    }
});

const paginatedPlaces = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return sortedPlaces.value.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(props.places.length / itemsPerPage);
});

// Methods
const toggleFilters = () => {
    // Implement filters modal/sidebar
};

const getBadgeClass = (badge) => {
    switch (badge) {
        case 'MICHELIN':
            return 'bg-red-50 text-red-700';
        case 'INSIDER':
            return 'bg-green-50 text-green-700';
        default:
            return 'bg-gray-50 text-gray-700';
    }
};

const previousImage = (place) => {
    if (place.currentImageIndex > 0) {
        place.currentImageIndex--;
    }
};

const nextImage = (place) => {
    if (place.currentImageIndex < place.images.length - 1) {
        place.currentImageIndex++;
    }
};

const initMap = () => {
    map.value = L.map('map').setView([48.8566, 2.3522], 13); // Default to Paris

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map.value);
};

const locateUser = () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const { latitude, longitude } = position.coords;
                userPosition.value = [latitude, longitude];
                map.value.setView(userPosition.value, 15);

                L.marker(userPosition.value)
                    .addTo(map.value)
                    .bindPopup('Vous êtes ici')
                    .openPopup();
            },
            (error) => {
                console.error('Erreur de géolocalisation :', error.message);
                alert('Impossible d’obtenir votre position.');
            }
        );
    } else {
        alert('La géolocalisation n’est pas supportée par ce navigateur.');
    }
};

onMounted(() => {
    initMap();
    locateUser();
});
</script>
