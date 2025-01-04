<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PlaceForm from './Paritials/Form.vue';

defineProps({
    categories: Array,
    cities: Array,
    countries: Array
});
</script>

<template>
    <AppLayout>
        <Head title="Create Place" />
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <PlaceForm
                :categories="categories"
                :cities="cities"
                :countries="countries"
            />
        </div>
    </AppLayout>
</template>
