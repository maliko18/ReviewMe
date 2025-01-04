// resources/js/Pages/Events/Index.vue
<script setup>
import {ref} from 'vue';
import {Link} from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import {CalendarIcon, ClockIcon, MapPinIcon, PlusCircleIcon} from 'lucide-react';
import EventModal from './EventModal.vue';
import {format, isAfter, isBefore, parseISO} from 'date-fns';

const props = defineProps({
    events: Object,
    places: Array,
    filters: Object
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

const getEventStatus = (event) => {
    const now = new Date();
    const startDate = parseISO(event.start_date);
    const endDate = parseISO(event.end_date);

    if (isBefore(now, startDate)) return 'Upcoming';
    if (isAfter(now, endDate)) return 'Past';
    return 'Ongoing';
};

const getStatusColor = (status) => {
    switch (status) {
        case 'Upcoming':
            return 'text-blue-600 bg-blue-100';
        case 'Ongoing':
            return 'text-green-600 bg-green-100';
        case 'Past':
            return 'text-gray-600 bg-gray-100';
        default:
            return 'text-gray-600 bg-gray-100';
    }
};
</script>

<template>
    <AdminLayout>
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Events</h1>
                <p class="mt-2 text-sm text-gray-700">
                    Manage all events for your places
                </p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <button
                    @click="openCreateModal"
                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    <PlusCircleIcon class="w-5 h-5 mr-2"/>
                    Add Event
                </button>
            </div>
        </div>

        <!-- Events Grid -->
        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div v-for="event in events.data"
                 :key="event.id"
                 class="relative bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <CalendarIcon class="w-5 h-5 text-gray-400"/>
                            <h3 class="text-lg font-medium text-gray-900">{{ event.name }}</h3>
                        </div>
                        <span :class="[
              getStatusColor(getEventStatus(event)),
              'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium'
            ]">
              {{ getEventStatus(event) }}
            </span>
                    </div>

                    <div class="mt-4 text-sm text-gray-500">
                        <div class="flex items-center mt-2">
                            <MapPinIcon class="w-4 h-4 mr-2"/>
                            {{ event.place.name }}
                        </div>
                        <div class="flex items-center mt-2">
                            <ClockIcon class="w-4 h-4 mr-2"/>
                            {{ format(parseISO(event.start_date), 'MMM d, yyyy') }}
                            {{ event.start_time }} - {{ event.end_time }}
                        </div>
                    </div>

                    <p class="mt-3 text-sm text-gray-600 line-clamp-2">
                        {{ event.description }}
                    </p>

                    <div class="mt-4 flex justify-end space-x-2">
                        <button
                            @click="openEditModal(event)"
                            class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div v-if="events.meta?.links?.length > 3" class="mt-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 flex justify-between sm:hidden">
                    <Link
                        v-if="events.meta.prev_page_url"
                        :href="events.meta.prev_page_url"
                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                    >
                        Previous
                    </Link>
                    <Link
                        v-if="events.meta.next_page_url"
                        :href="events.meta.next_page_url"
                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                    >
                        Next
                    </Link>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing
                            <span class="font-medium">{{ events.meta.from }}</span>
                            to
                            <span class="font-medium">{{ events.meta.to }}</span>
                            of
                            <span class="font-medium">{{ events.meta.total }}</span>
                            results
                        </p>
                    </div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                        <Link
                            v-for="(link, index) in events.meta.links"
                            :key="index"
                            :href="link.url"
                            v-show="link.url && index !== 0 && index !== events.meta.links.length - 1"
                            :class="[
                link.active ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                'relative inline-flex items-center px-4 py-2 border text-sm font-medium'
              ]"
                            v-html="link.label"
                        />
                    </nav>
                </div>
            </div>
        </div>

        <EventModal
            v-if="showEventModal"
            v-model="showEventModal"
            :event="editingEvent"
            :places="places"
            @close="showEventModal = false"
        />
    </AdminLayout>
</template>
