<script setup>
defineProps({
    place: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <div class="p-6">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">{{ place.name }}</h2>
            <p class="mt-2 text-gray-600">{{ place.description }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Categories -->
            <div>
                <h3 class="font-semibold text-gray-900">Categories</h3>
                <div class="mt-2 flex flex-wrap gap-2">
                    <span
                        v-for="category in place.categories"
                        :key="category.id"
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800"
                    >
                        {{ category.name }}
                    </span>
                </div>
            </div>

            <!-- Address -->
            <div>
                <h3 class="font-semibold text-gray-900">Address</h3>
                <div v-if="place.address" class="mt-2 text-gray-600">
                    <p>{{ place.address.address }}</p>
                    <p>{{ place.address.city?.name }}, {{ place.address.state }}</p>
                    <p>{{ place.address.country?.name }} {{ place.address.zip }}</p>
                </div>
            </div>

            <!-- Images -->
            <div class="md:col-span-2">
                <h3 class="font-semibold text-gray-900 mb-2">Images</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <img
                        v-for="image in place.images"
                        :key="image.id"
                        :src="`${image.path}`"
                        :alt="place.name"
                        class="h-32 w-full object-cover rounded-lg"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
