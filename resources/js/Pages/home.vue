<template>
    <div class="min-h-screen flex flex-col bg-gray-100">
        <!-- Navbar -->
        <header class="bg-white shadow-md py-4 px-8 flex justify-between items-center">
            <!-- Logo -->
            <div class="text-xl font-bold text-green-700 flex items-center">
                <img src="https://via.placeholder.com/30" alt="Logo" class="mr-2" />
                TheFork
            </div>
            <!-- Menu -->
            <div class="flex space-x-6 items-center text-sm">
                <a href="#" class="hover:underline">INSCRIRE MON RESTAURANT</a>
                <a href="#" class="hover:underline">AIDE</a>
                <button class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 text-sm">
                    TÉLÉCHARGER L'APPLICATION
                </button>
                <button class="px-4 py-2 bg-primary text-white rounded">
                    CONNEXION
                </button>
            </div>
        </header>

        <!-- Hero Section -->
        <div class="flex flex-col items-center bg-primary text-white p-32 px-8 relative m-16 rounded-lg">
            <!-- Text Content -->
            <div class="text-center">
                <h1 class="text-3xl md:text-5xl font-bold mb-6">
                    Découvrez et réservez le meilleur restaurant
                </h1>
                <!-- Search Bar -->
                <div class="flex bg-white text-gray-700 rounded-lg overflow-hidden shadow-md">
                    <div class="flex items-center px-4">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-gray-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5.121 19.071A10 10 0 0114.829 9.243l1.415-1.415a10 10 0 11-1.415 1.415l-1.415 1.415a10 10 0 01-7.071 7.071z"
                            />
                        </svg>
                    </div>
                    <input
                        type="text"
                        placeholder="Paris"
                        class="flex-1 px-4 py-2 border-r border-gray-300"
                    />
                    <input
                        type="text"
                        placeholder="Cuisine, nom de restaurant..."
                        class="flex-1 px-4 py-2"
                    />
                    <button class="bg-green-700 text-white px-6 py-2 hover:bg-green-600">
                        RECHERCHE
                    </button>
                </div>
            </div>
        </div>

        <div class="popular-restaurants px-8 py-6">
            <!-- Section for Paris -->
            <div class="mb-8">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">Restaurants populaires à Paris</h2>
                    <a href="#" class="text-blue-600 hover:underline">Voir plus</a>
                </div>
                <swiper
                    :modules="swiperModules"
                    navigation
                    pagination
                    space-between="16"
                    slides-per-view="4"
                    class="mt-4"
                >
                    <swiper-slide
                        v-for="restaurant in parisRestaurants"
                        :key="restaurant.id"
                        class="bg-white shadow rounded overflow-hidden"
                    >
                        <img :src="restaurant.image" alt="Restaurant Image" class="w-full h-40 object-cover" />
                        <div class="p-4">
                            <p class="text-sm uppercase text-gray-500">{{ restaurant.type }}</p>
                            <h3 class="text-lg font-bold">{{ restaurant.name }}</h3>
                            <p class="text-sm text-gray-500">Prix moyen: {{ restaurant.price }} €</p>
                            <div class="mt-3">
                                <button
                                    class="bg-black text-white text-sm px-4 py-2 rounded hover:bg-gray-800"
                                >
                                    Jusqu'à {{ restaurant.discount }}%
                                </button>
                            </div>
                        </div>
                    </swiper-slide>
                </swiper>
            </div>

            <!-- Section for Lyon -->
            <div>
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">Restaurants populaires à Lyon</h2>
                    <a href="#" class="text-blue-600 hover:underline">Voir plus</a>
                </div>
                <swiper
                    :modules="swiperModules"
                    navigation
                    pagination
                    space-between="16"
                    slides-per-view="4"
                    class="mt-4"
                >
                    <swiper-slide
                        v-for="restaurant in lyonRestaurants"
                        :key="restaurant.id"
                        class="bg-white shadow rounded overflow-hidden"
                    >
                        <img :src="restaurant.image" alt="Restaurant Image" class="w-full h-40 object-cover" />
                        <div class="p-4">
                            <p class="text-sm uppercase text-gray-500">{{ restaurant.type }}</p>
                            <h3 class="text-lg font-bold">{{ restaurant.name }}</h3>
                            <p class="text-sm text-gray-500">Prix moyen: {{ restaurant.price }} €</p>
                            <div class="mt-3">
                                <button
                                    class="bg-black text-white text-sm px-4 py-2 rounded hover:bg-gray-800"
                                >
                                    Jusqu'à {{ restaurant.discount }}%
                                </button>
                            </div>
                        </div>
                    </swiper-slide>
                </swiper>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import {Swiper, SwiperSlide} from "swiper/vue";
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/swiper-bundle.css';

// Swiper Modules
const swiperModules = [Navigation, Pagination];

// Paris Restaurants Data
const parisRestaurants = ref([
    {
        id: 1,
        name: "Terry's Café",
        type: 'Français',
        price: 19,
        discount: 50,
        image: 'https://res.cloudinary.com/tf-lab/image/upload/w_6…b9298fb2/3e25e8aa-5fc0-492f-8c6b-4b1bccb44ae1.jpg\n',
    },
    {
        id: 2,
        name: "L'Imperatif",
        type: 'Français',
        price: 19,
        discount: 50,
        image: 'https://res.cloudinary.com/tf-lab/image/upload/w_6…b9298fb2/3e25e8aa-5fc0-492f-8c6b-4b1bccb44ae1.jpg\n',
    },
    {
        id: 3,
        name: 'Eat Day',
        type: 'Japonais',
        price: 15,
        discount: 50,
        image: 'https://res.cloudinary.com/tf-lab/image/upload/w_6…b9298fb2/3e25e8aa-5fc0-492f-8c6b-4b1bccb44ae1.jpg\n',
    },
    {
        id: 4,
        name: 'Beef Burger Steakhouse',
        type: 'Sud-Ouest',
        price: 20,
        discount: 50,
        image: 'https://res.cloudinary.com/tf-lab/image/upload/w_6…b9298fb2/3e25e8aa-5fc0-492f-8c6b-4b1bccb44ae1.jpg\n',
    },
]);

// Lyon Restaurants Data
const lyonRestaurants = ref([
    {
        id: 1,
        name: 'Matsuri Lyon Part-Dieu',
        type: 'Japonais',
        price: 21,
        discount: 30,
        image: 'https://res.cloudinary.com/tf-lab/image/upload/w_6…b9298fb2/3e25e8aa-5fc0-492f-8c6b-4b1bccb44ae1.jpg\n',
    },
    {
        id: 2,
        name: 'Matsuri Lyon Valse',
        type: 'Japonais',
        price: 21,
        discount: 30,
        image: 'https://res.cloudinary.com/tf-lab/image/upload/w_6…b9298fb2/3e25e8aa-5fc0-492f-8c6b-4b1bccb44ae1.jpg\n',
    },
    {
        id: 3,
        name: 'Matsuri Lyon Presqu’île',
        type: 'Japonais',
        price: 22,
        discount: 30,
        image: 'https://res.cloudinary.com/tf-lab/image/upload/w_6…b9298fb2/3e25e8aa-5fc0-492f-8c6b-4b1bccb44ae1.jpg\n',
    },
    {
        id: 4,
        name: 'Cavallo Restaurant',
        type: 'Pizzeria',
        price: 25,
        discount: 20,
        image: 'https://res.cloudinary.com/tf-lab/image/upload/w_6…b9298fb2/3e25e8aa-5fc0-492f-8c6b-4b1bccb44ae1.jpg\n',
    },
]);
</script>

<style scoped>
/* Add custom styling if needed */
</style>
