<!-- resources/js/Components/SwitchTheme.vue -->
<template>
    <button @click="toggleTheme" class="p-2 rounded-full hover:bg-gray-800">
        <SunIcon v-if="isDark" class="w-5 h-5" />
        <MoonIcon v-else class="w-5 h-5" />
    </button>
</template>

<script setup>
import { ref } from 'vue'
import { SunIcon, MoonIcon } from 'lucide-vue-next'

const isDark = ref(false)

const toggleTheme = () => {
    isDark.value = !isDark.value
    document.documentElement.classList.toggle('dark')
}
</script>
