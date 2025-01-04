// resources/js/Layouts/MainLayout.vue
<script setup>
import { computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import {MenuButton, MenuItem, MenuItems} from "@headlessui/vue";

const props = defineProps({
    title: String,
});

const { auth } = usePage().props;
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <Head :title="title" />

        <Navbar :auth="auth" />

        <main>
            <slot />
        </main>

        <Footer />
    </div>
</template>


