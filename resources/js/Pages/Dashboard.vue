<!-- resources/js/Pages/Home.vue -->
<template>
    <MainLayout>
        <!-- Hero Section -->
        <div class="bg-teal-800 h-[500px] relative">
            <img
                src="/images/hero-dish.jpg"
                class="absolute right-0 top-0 h-full w-1/2 object-cover object-left"
                alt="Dish"
            />
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
                <div class="flex items-center h-full w-1/2">
                    <div class="text-white">
                        <h1 class="text-4xl font-bold mb-8">
                            Découvrez et réservez le meilleur restaurant
                        </h1>
                        <SearchBar class="max-w-xl" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Popular Restaurants Sections -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <RestaurantSection
                    v-for="section in sections"
                    :key="section.title"
                    :title="section.title"
                    :restaurants="section.restaurants"
                />

                <!-- French Cities -->
                <div class="mt-16">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold">Autres villes en France</h2>
                        <div class="flex gap-2">
                            <button
                                class="p-2 rounded-full hover:bg-gray-100"
                                @click="scrollCities('prev')"
                            >
                                <ChevronLeftIcon class="w-5 h-5" />
                            </button>
                            <button
                                class="p-2 rounded-full hover:bg-gray-100"
                                @click="scrollCities('next')"
                            >
                                <ChevronRightIcon class="w-5 h-5" />
                            </button>
                        </div>
                    </div>

                    <div class="relative">
                        <div ref="citiesContainer" class="flex gap-4 overflow-hidden">
                            <Link
                                v-for="city in cities"
                                :key="city.name"
                                :href="route('places.index', { city: city.slug })"
                                class="relative min-w-[200px] h-32 rounded-lg overflow-hidden group"
                            >
                                <img
                                    :src="city.image"
                                    :alt="city.name"
                                    class="w-full h-full object-cover transition-transform group-hover:scale-110"
                                />
                                <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                                    <span class="text-white font-semibold text-lg">{{ city.name }}</span>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- International Restaurants -->
                <div class="mt-16">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold">TheFork à l'international</h2>
                        <div class="flex items-center gap-4">
                            <Link
                                href="/international"
                                class="text-sm text-teal-600 hover:text-teal-700"
                            >
                                VOIR PLUS
                            </Link>
                            <div class="flex gap-2">
                                <button
                                    class="p-2 rounded-full hover:bg-gray-100"
                                    @click="scrollInternational('prev')"
                                >
                                    <ChevronLeftIcon class="w-5 h-5" />
                                </button>
                                <button
                                    class="p-2 rounded-full hover:bg-gray-100"
                                    @click="scrollInternational('next')"
                                >
                                    <ChevronRightIcon class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div ref="internationalContainer" class="flex gap-4 overflow-hidden">
                            <Link
                                v-for="city in internationalCities"
                                :key="city.name"
                                :href="route('places.index', { city: city.slug })"
                                class="relative min-w-[300px] h-48 rounded-lg overflow-hidden group"
                            >
                                <img
                                    :src="city.image"
                                    :alt="city.name"
                                    class="w-full h-full object-cover transition-transform group-hover:scale-110"
                                />
                                <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                                    <span class="text-white font-semibold text-xl">{{ city.name }}</span>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { ChevronLeftIcon, ChevronRightIcon } from 'lucide-vue-next'
import MainLayout from '@/Layouts/MainLayout.vue'
import SearchBar from '@/Components/SearchBar.vue'
import RestaurantSection from '@/Components/RestaurantSection.vue'

const citiesContainer = ref(null)
const internationalContainer = ref(null)

const sections = ref([
    {
        title: 'Restaurants populaires à Paris',
        restaurants: [
            {
                name: 'Terry\'s Café',
                cuisine: 'FRANÇAIS',
                rating: 8.7,
                price: 19,
                discount: 50,
                image: '/images/restaurants/terrys.jpg'
            },
            // Add more restaurants
        ]
    },
    {
        title: 'Restaurants populaires à Lyon',
        restaurants: [
            // Add Lyon restaurants
        ]
    }
])

const cities = ref([
    { name: 'Paris', slug: 'paris', image: '/images/cities/paris.jpg' },
    { name: 'Lyon', slug: 'lyon', image: '/images/cities/lyon.jpg' },
    { name: 'Marseille', slug: 'marseille', image: '/images/cities/marseille.jpg' },
    { name: 'Bordeaux', slug: 'bordeaux', image: '/images/cities/bordeaux.jpg' },
    { name: 'Toulouse', slug: 'toulouse', image: '/images/cities/toulouse.jpg' },
    { name: 'Montpellier', slug: 'montpellier', image: '/images/cities/montpellier.jpg' }
])

const internationalCities = ref([
    { name: 'Barcelone', slug: 'barcelona', image: '/images/cities/barcelona.jpg' },
    { name: 'Madrid', slug: 'madrid', image: '/images/cities/madrid.jpg' },
    { name: 'Valencia', slug: 'valencia', image: '/images/cities/valencia.jpg' }
])

const scrollContent = (container, direction) => {
    const scrollAmount = 400
    container.value.scrollLeft += direction === 'next' ? scrollAmount : -scrollAmount
}

const scrollCities = (direction) => scrollContent(citiesContainer, direction)
const scrollInternational = (direction) => scrollContent(internationalContainer, direction)
</script>
