<script setup>
defineProps({
    title: String,
    description: String
});
</script>

<template>
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div v-if="title || description" class="px-4 py-5 sm:px-6">
            <h3 v-if="title" class="text-lg leading-6 font-medium text-gray-900">
                {{ title }}
            </h3>
            <p v-if="description" class="mt-1 text-sm text-gray-500">
                {{ description }}
            </p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <slot />
        </div>
        <div v-if="$slots.footer" class="px-4 py-4 sm:px-6 bg-gray-50">
            <slot name="footer" />
        </div>
    </div>
</template>
