<!-- resources/js/Pages/Admin/Restaurants/Index.vue -->
<template>
    <AdminLayout>
        <div class="flex flex-col gap-4">
            <PlaceInformations  />
            <PlaceAddresses  :place-id="1"/>
            <PlaceGallery  :place-id="1"/>
        </div>

    </AdminLayout>

</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import {Link} from "@inertiajs/vue3";
import PlaceInformations from "@/Pages/Admin/Places/Paritials/PlaceInformations.vue";
import PlaceAddresses from "@/Pages/Admin/Places/Paritials/PlaceAddresses.vue";
import PlaceGallery from "@/Pages/Admin/Places/Paritials/PlaceGallery.vue";
</script>
