<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { CheckCircleIcon, XCircleIcon } from 'lucide-react';

const show = ref(false);
const message = ref('');
const type = ref('success');

watch(() => usePage().props.flash, (newFlash) => {
    if (newFlash.success || newFlash.error) {
        message.value = newFlash.success || newFlash.error;
        type.value = newFlash.success ? 'success' : 'error';
        show.value = true;
        setTimeout(() => (show.value = false), 3000);
    }
}, { deep: true });
</script>

<template>
    <div
        v-show="show"
        class="fixed bottom-4 right-4 z-50 max-w-sm bg-white rounded-lg shadow-lg"
        :class="{
      'border-l-4 border-green-400': type === 'success',
      'border-l-4 border-red-400': type === 'error'
    }"
    >
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <CheckCircleIcon v-if="type === 'success'" class="h-6 w-6 text-green-400" />
                    <XCircleIcon v-else class="h-6 w-6 text-red-400" />
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ message }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
