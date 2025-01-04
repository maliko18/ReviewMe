// resources/js/Layouts/AdminLayout.vue
<script setup>
import { computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PageHeader from '@/Components/PageHeader.vue';

const props = defineProps({
    title: {
        type: String,
        required: false
    },
    description: {
        type: String,
        required: false
    }
});

const pageTitle = computed(() => {
    return props.title ? `${props.title} - Admin` : 'Admin Dashboard';
});
</script>

<template>
    <AppLayout>
        <Head :title="pageTitle" />

        <PageHeader v-if="title || description" :title="title" :description="description">
            <template #actions>
                <slot name="actions" />
            </template>
        </PageHeader>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <slot />
            </div>
        </div>
    </AppLayout>
</template>
