<script setup>
import {ref, watch} from 'vue';
import {router} from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import {SearchIcon, XIcon} from 'lucide-react';

const props = defineProps({
    modelValue: String,
    placeholder: {
        type: String,
        default: 'Search...'
    }
});

const emit = defineEmits(['update:modelValue']);
const search = ref(props.modelValue);

const updateSearch = debounce((value) => {
    emit('update:modelValue', value);
    router.get(
        route().current(),
        {search: value},
        {preserveState: true, preserveScroll: true, replace: true}
    );
}, 300);

watch(search, updateSearch);
</script>

<template>
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <SearchIcon class="h-5 w-5 text-gray-400"/>
        </div>
        <input
            v-model="search"
            type="search"
            :placeholder="placeholder"
            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        />
        <button
            v-if="search"
            @click="search = ''"
            class="absolute inset-y-0 right-0 pr-3 flex items-center"
        >
            <XIcon class="h-5 w-5 text-gray-400 hover:text-gray-500"/>
        </button>
    </div>
</template>
