<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Modal from '@/Components/Modal.vue';
import SearchFilter from '@/Components/SearchFilter.vue';
import PlaceCard from '@/Components/PlaceCard.vue';
import PlaceForm from "@/Components/PlaceForm.vue";
import PlaceDetails from "@/Components/PlaceDetails.vue";

const props = defineProps({
    places: Object,
    filters: Object,
    categories: Array,
    cities: Array,
    countries: Array
});

const search = ref(props.filters?.search || '');
const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDetailsModal = ref(false);
const selectedPlace = ref(null);

const openEditModal = (place) => {
    selectedPlace.value = place;
    showEditModal.value = true;
};

const openDetailsModal = (place) => {
    selectedPlace.value = place;
    showDetailsModal.value = true;
};
</script>

<template>
    <AppLayout>
        <Head title="Places" />

        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Places</h1>
                <p class="mt-2 text-sm text-gray-700">A list of all places in your directory.</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <button
                    v-if="$page.props.can.create_places"
                    @click="showCreateModal = true"
                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700"
                >
                    Add Place
                </button>
            </div>
        </div>

<!--        <div class="mt-6">
            <SearchFilter v-model="search" class="w-full lg:w-1/3" />
        </div>-->

        <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <PlaceCard
                v-for="place in places.data"
                :key="place.id"
                :place="place"
                @click="openDetailsModal(place)"
                @edit="openEditModal(place)"
            />
        </div>

        <!-- Modals -->
        <Modal :show="showCreateModal" @close="showCreateModal = false">
            <PlaceForm
                :categories="categories"
                :cities="cities"
                :countries="countries"
                @submitted="showCreateModal = false"
            />
        </Modal>

        <Modal :show="showEditModal" @close="showEditModal = false">
            <PlaceForm
                v-if="selectedPlace"
                :place="selectedPlace"
                :categories="categories"
                :cities="cities"
                :countries="countries"
                @submitted="showEditModal = false"
            />
        </Modal>

        <Modal :show="showDetailsModal" @close="showDetailsModal = false">
            <PlaceDetails
                v-if="selectedPlace"
                :place="selectedPlace"
            />
        </Modal>
    </AppLayout>
</template>
