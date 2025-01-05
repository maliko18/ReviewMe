# Index.vue
<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import AdBannerForm from '@/Components/AdBannerForm.vue';
import { Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    banners: Object,
    places: Array
});

const showModal = ref(false);
const editingBanner = ref(null);

const openCreateModal = () => {
    editingBanner.value = null;
    showModal.value = true;
};

const openEditModal = (banner) => {
    editingBanner.value = banner;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    editingBanner.value = null;
};
</script>

<template>
    <AppLayout title="Ad Banners">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ad Banners
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex justify-end mb-4">
                        <PrimaryButton @click="openCreateModal">
                            Create Banner
                        </PrimaryButton>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Place
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Dates
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Images
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="banner in banners.data" :key="banner.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ banner.title }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ banner.place?.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ banner.start_date }} - {{ banner.end_date }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="{
                                            'px-2 inline-flex text-xs leading-5 font-semibold rounded-full': true,
                                            'bg-green-100 text-green-800': banner.status,
                                            'bg-red-100 text-red-800': !banner.status
                                        }">
                                            {{ banner.status ? 'Active' : 'Inactive' }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex -space-x-2">
                                        <img
                                            v-for="image in banner.images.slice(0, 3)"
                                            :key="image.id"
                                            :src="image.path"
                                            class="h-8 w-8 rounded-full ring-2 ring-white object-cover"
                                        >
                                        <div v-if="banner.images.length > 3"
                                             class="h-8 w-8 rounded-full bg-gray-100 ring-2 ring-white flex items-center justify-center text-xs text-gray-500">
                                            +{{ banner.images.length - 3 }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button
                                        @click="openEditModal(banner)"
                                        class="text-indigo-600 hover:text-indigo-900 mr-4"
                                    >
                                        Edit
                                    </button>
                                    <Link
                                        :href="route('admin.banners.destroy', banner.id)"
                                        method="delete"
                                        as="button"
                                        class="text-red-600 hover:text-red-900"
                                        preserve-scroll
                                        preserve-state
                                    >
                                        Delete
                                    </Link>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <AdBannerForm
            v-model="showModal"
            :banner="editingBanner"
            :places="places"
            @close="closeModal"
        />
    </AppLayout>
</template>
