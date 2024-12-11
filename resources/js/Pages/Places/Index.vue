<template>
    <div class="flex h-screen flex-col px-32">
        <div class="flex w-full">
            <div class="w-2/3 h-screen overflow-y-auto p-4 space-y-4 bg-gray-50">
                <!-- Restaurant Card with Image Slider -->
                <Link :href="`places/${restaurant.slug}`"
                    v-for="restaurant in currentPlaces"
                    :key="restaurant.id"
                    class="flex bg-white shadow rounded-lg p-4 space-x-4"
                >
                    <!-- Slider -->
                    <div class="swiper-container rounded overflow-hidden w-[300px] h-[200px]">
                        <swiper
                            :modules="swiperModules"
                            navigation
                            pagination
                            class="h-full"
                        >
                            <swiper-slide
                                v-for="(image, index) in restaurant.images"
                                :key="index"
                            >
                                <img
                                    :src="image"
                                    alt="Restaurant Image"
                                    class="w-full h-full object-cover"
                                />
                            </swiper-slide>
                        </swiper>
                    </div>

                    <!-- Restaurant Info -->
                    <div class="mt-4 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold">{{ restaurant.name }}</h3>
                        <p class="text-sm text-gray-500">{{ restaurant.address }}</p>
                        <p class="text-sm text-gray-700 mt-1">
                            Prix moyen: <span class="font-semibold">{{ restaurant.price }} €</span>
                        </p>
                        <p class="text-sm italic text-gray-600 mt-1">
                            {{ restaurant.description }}
                        </p>
                        <div class="flex justify-between items-center mt-auto">
                        <span class="text-lg font-bold text-green-500">
                            {{ restaurant.rating }}
                        </span>
                            <span class="text-sm text-gray-500">{{ restaurant.reviews }} avis</span>
                        </div>
                    </div>
                </Link>
            </div>

            <!-- Right Side (Fixed Map) -->
            <div class="w-1/3 h-screen sticky top-0">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d10497.822531941003!2d2.3522219!3d48.856614!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjLCsDUxJzIxLjgiTiAywrAyMCczMi4wIkU!5e0!3m2!1sen!2sfr!4v1675828004552!5m2!1sen!2sfr"
                    class="w-full h-full border-none"
                    allowfullscreen=""
                    loading="lazy"
                ></iframe>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import {computed, ref} from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/swiper-bundle.css';
const props=defineProps({
    places:Array
})

const currentPlaces=computed(()=>{
    return props.places.map((place)=>{
        return {
            id:place.id,
            name:place.name,
            slug:place.slug,
            address:'20 Rue du Cirque, 75008, Paris',
            price:105,
            description:place.description,
            rating:9.5,
            reviews:653,
            images:place.images?.map((image)=>image.path)
        }
    })
})
const swiperModules = [Navigation, Pagination];
</script>

<style>
/* Add global styles if needed */
</style>
