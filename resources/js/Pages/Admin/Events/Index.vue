# Events/Index.vue
<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import EventForm from './EventModal.vue';
import { Link } from '@inertiajs/vue3';
import EventModal from "@/Pages/Admin/Events/EventModal.vue";

const props = defineProps({
    events: Object,
    places: Array
});

const showEventModal = ref(false);
const editingEvent = ref(null);

const openCreateModal = () => {
    editingEvent.value = null;
    showEventModal.value = true;
};

const openEditModal = (event) => {
    editingEvent.value = event;
    showEventModal.value = true;
};

const closeModal = () => {
    showEventModal.value = false;
    editingEvent.value = null;
};
</script>

<template>
    <AppLayout title="Events">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Events
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex justify-end mb-4">
                        <PrimaryButton @click="openCreateModal">
                            Create Event
                        </PrimaryButton>
                    </div>

                    <!-- Events List -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Place
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Dates
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Images
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="event in events.data" :key="event.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ event.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ event.place?.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ event.start_date }} - {{ event.end_date }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="{
                                            'px-2 inline-flex text-xs leading-5 font-semibold rounded-full': true,
                                            'bg-green-100 text-green-800': event.status,
                                            'bg-red-100 text-red-800': !event.status
                                        }">
                                            {{ event.status ? 'Active' : 'Inactive' }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex -space-x-2">
                                        <img v-for="image in event.images?.slice(0, 3)"
                                            :key="image.id"
                                            :src="image.path"
                                            class="h-8 w-8 rounded-full ring-2 ring-white object-cover"
                                        >
                                        <div v-if="event.images?.length > 3" class="h-8 w-8 rounded-full bg-gray-100 ring-2 ring-white flex items-center justify-center text-xs text-gray-500">
                                        +{{ event.images.length - 3 }}
                                    </div>
                    </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button
                            @click="openEditModal(event)"
                            class="text-indigo-600 hover:text-indigo-900 mr-4"
                        >
                            Edit
                        </button>
                        <Link
                            :href="route('admin.events.destroy', event.id)"
                            method="delete"
                            as="button"
                            class="text-red-600 hover:text-red-900"
                            preserve-scroll
                        >
                            Delete
                        </Link>
                    </td>
                    </tr>
                    </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    <!-- Add your pagination component here -->
                </div>
            </div>
        </div>
        </div>

        <!-- Event Modal -->
        <EventModal
            v-model="showEventModal"
            :event="editingEvent"
            :places="places"
            @close="closeModal"
        />
    </AppLayout>
</template>
