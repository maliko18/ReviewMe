<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import { UserIcon, MenuIcon, XIcon } from 'lucide-vue-next';

defineProps({
    auth: Object,
});

const mobileMenuOpen = ref(false);
</script>

<template>
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <Link :href="route('welcome')">
                            <img class="h-8 w-auto" src="/images/logo.svg" alt="Logo">
                        </Link>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <Link
                            :href="route('places.index')"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900"
                        >
                            Places
                        </Link>
                        <Link
                            :href="route('categories.index')"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-900"
                        >
                            Categories
                        </Link>
                        <Link
                            :href="route('about')"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-900"
                        >
                            About
                        </Link>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="flex items-center">
                    <!-- User Menu -->
                    <div v-if="auth.user" class="ml-3 relative">
                        <Menu as="div">
                            <MenuButton class="flex items-center">
                                <span class="sr-only">Open user menu</span>
                                <img
                                    v-if="auth.user.profile_photo_url"
                                    :src="auth.user.profile_photo_url"
                                    class="h-8 w-8 rounded-full object-cover"
                                >
                                <UserIcon v-else class="h-8 w-8 text-gray-400" />
                            </MenuButton>

                            <MenuItems class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                                <MenuItem v-slot="{ active }">
                                    <Link
                                        :href="route('profile.show')"
                                        :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']"
                                    >
                                        Your Profile
                                    </Link>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <Link
                                        :href="route('places.user')"
                                        :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']"
                                    >
                                        Your Places
                                    </Link>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <Link
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        class="w-full text-left"
                                        :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']"
                                    >
                                        Sign out
                                    </Link>
                                </MenuItem>
                            </MenuItems>
                        </Menu>
                    </div>
                    <div v-else class="flex items-center space-x-4">
                        <Link
                            :href="route('login')"
                            class="text-sm font-medium text-gray-500 hover:text-gray-900"
                        >
                            Sign in
                        </Link>
                        <Link
                            :href="route('register')"
                            class="text-sm font-medium text-white bg-teal-600 px-4 py-2 rounded-md hover:bg-teal-700"
                        >
                            Sign up
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div v-show="mobileMenuOpen" class="sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <Link
                    :href="route('places.index')"
                    class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-50"
                >
                    Places
                </Link>
                <Link
                    :href="route('categories.index')"
                    class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-50"
                >
                    Categories
                </Link>
                <Link
                    :href="route('about')"
                    class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-50"
                >
                    About
                </Link>
            </div>
        </div>
    </nav>
</template>
