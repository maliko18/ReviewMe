<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SearchFilter from '@/Components/SearchFilter.vue';
import PlaceCard from '@/Components/PlaceCard.vue';

const props = defineProps({
    places: Object,
    filters: Object
});

const search = ref(props.filters?.search || '');
</script>

<template>
    <AppLayout>
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Places</h1>
                <p class="mt-2 text-sm text-gray-700">
                    A list of all places in your directory.
                </p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <Link
                    v-if="$page.props.can.create_places"
                    :href="route('admin.places.create')"
                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700"
                >
                    Add Place
                </Link>
            </div>
        </div>

        <!-- Filters -->
        <div class="mt-6">
            <SearchFilter
                v-model="search"
                placeholder="Search places..."
                class="w-full lg:w-1/3"
            />
        </div>

        <!-- Places Grid -->
        <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <PlaceCard
                v-for="place in places.data"
                :key="place.id"
                :place="place"
            />
        </div>

        <!--        &lt;!&ndash; Pagination &ndash;&gt;
                <div v-if="places.meta.links.length > 3" class="mt-6">
                    &lt;!&ndash; ... Pagination component ... &ndash;&gt;
                </div>-->
    </AppLayout>
</template>
