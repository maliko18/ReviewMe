<script setup>
defineProps({
    title: String,
    description: String
});
</script>

<template>
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h1 v-if="title" class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">
                {{ title }}
            </h1>
            <p v-if="description" class="mt-1 text-sm text-gray-500">
                {{ description }}
            </p>
        </div>
        <div v-if="$slots.actions" class="mt-4 flex md:mt-0 md:ml-4">
            <slot name="actions" />
        </div>
    </div>
</template>
