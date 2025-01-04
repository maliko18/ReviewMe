<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <div class="flex items-center justify-between">
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">{{ meta.from }}</span>
                    to
                    <span class="font-medium">{{ meta.to }}</span>
                    of
                    <span class="font-medium">{{ meta.total }}</span>
                    results
                </p>
            </div>
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                <Link
                    v-for="(link, key) in links"
                    :key="key"
                    v-show="link.url && key !== 0 && key !== links.length - 1"
                    :href="link.url"
                    :class="[
            link.active
              ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
              : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
            'relative inline-flex items-center px-4 py-2 border text-sm font-medium'
          ]"
                    v-html="link.label"
                />
            </nav>
        </div>
    </div>
</template>
