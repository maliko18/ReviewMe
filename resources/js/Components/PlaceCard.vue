<script setup>
defineProps({
    place: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['edit', 'click']);
</script>

<template>
    <div
        class="bg-white shadow rounded-lg overflow-hidden cursor-pointer hover:shadow-lg transition-shadow"
        @click="emit('click')"
    >
        <img
            v-if="place.images?.[0]"
            :src="`${place.images[0].path}`"
            :alt="place.name"
            class="w-full h-48 object-cover"
        />

        <div class="p-4">
            <h3 class="text-lg font-medium text-gray-900">{{ place.name }}</h3>
            <p class="mt-1 text-sm text-gray-500">{{ place.description }}</p>

            <div class="mt-4 flex justify-between items-center">
                <div class="flex flex-wrap gap-2">
                    <span
                        v-for="category in place.categories.slice(0, 2)"
                        :key="category.id"
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800"
                    >
                        {{ category.name }}
                    </span>
                </div>

                <button
                    v-if="$page.props.can.update_places"
                    @click.stop="emit('edit')"
                    class="inline-flex items-center p-2 text-gray-400 hover:text-gray-500"
                >
                    <PencilIcon class="h-5 w-5" />
                </button>
            </div>
        </div>
    </div>
</template>
