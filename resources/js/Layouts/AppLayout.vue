// resources/js/Layouts/AppLayout.vue
<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import {
    HomeIcon, MapPinIcon, CalendarIcon, StarIcon, TagIcon,
    Settings2Icon, UserIcon, MenuIcon, XIcon, BellIcon,
    LayoutDashboardIcon, ImageIcon,
} from 'lucide-vue-next';
import Dropdown from '@/Components/Dropdown.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import DropdownLink from "@/Components/DropdownLink.vue";

const showingSidebar = ref(false);
const { auth, can } = usePage().props;

const navigation = computed(() => [
    { name: 'Dashboard', href: route('admin.dashboard'), icon: LayoutDashboardIcon, can: true },
    { name: 'Places', href: route('admin.places.index'), icon: MapPinIcon, can: can.create_places },
    { name: 'Categories', href: route('admin.categories.index'), icon: TagIcon, can: can.manage_categories },
    { name: 'Events', href: route('admin.events.index'), icon: CalendarIcon, can: can.manage_events },
    { name: 'Reviews', href: route('admin.reviews.index'), icon: StarIcon, can: can.manage_reviews },
    { name: 'Ad Banners', href: route('admin.banners.index'), icon: StarIcon, can: can.manage_banners },
   /* { name: 'Media', href: route('media.index'), icon: ImageIcon, can: can.manage_media },*/
 /*   { name: 'Settings', href: route('settings.index'), icon: Settings2Icon, can: can.manage_settings },*/
].filter(item => item.can));
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar for desktop -->
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <div class="flex-1 flex flex-col min-h-0 bg-indigo-700">
                <div class="flex items-center justify-center h-16 flex-shrink-0 px-4 bg-indigo-800">
                    <img class="h-8 w-auto" src="/images/logo.svg" alt="Logo" />
                </div>
                <div class="flex-1 flex flex-col overflow-y-auto">
                    <nav class="flex-1 px-2 py-4 space-y-1">
                        <Link
                            v-for="item in navigation"
                            :key="item.name"
                            :href="item.href"
                            :class="[
                $page.url.startsWith(item.href)
                  ? 'bg-indigo-800 text-white'
                  : 'text-indigo-100 hover:bg-indigo-600',
                'group flex items-center px-2 py-2 text-sm font-medium rounded-md'
              ]"
                        >
<!--                            <component
                                :is="item.icon"
                                :class="[
                  $page.url.startsWith(item.href) ? 'text-white' : 'text-indigo-300',
                  'mr-3 flex-shrink-0 h-6 w-6'
                ]"
                            />-->
                            {{ item.name }}
                        </Link>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden" v-show="showingSidebar">
            <div class="fixed inset-0 z-40 flex">
                <div class="fixed inset-0" @click="showingSidebar = false">
                    <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
                </div>
                <div class="relative flex-1 flex flex-col max-w-xs w-full bg-indigo-700">
                    <!-- Mobile sidebar content -->
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="md:pl-64 flex flex-col flex-1">
            <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white shadow">
                <button
                    @click="showingSidebar = true"
                    type="button"
                    class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden"
                >
                    <MenuIcon class="h-6 w-6" />
                </button>

                <div class="flex-1 px-4 flex justify-between">
                    <div class="flex-1 flex"></div>
                    <div class="ml-4 flex items-center md:ml-6">
                        <!-- Notifications -->
                        <button class="p-1 rounded-full text-gray-400 hover:text-gray-500">
                            <BellIcon class="h-6 w-6" />
                        </button>

                        <!-- Profile dropdown -->
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                    <div class="ml-3 relative">
                                        <div class="flex items-center">
                                            <img
                                                v-if="$page.props.auth.user?.profile_photo_url"
                                                :src="$page.props.auth.user?.profile_photo_url"
                                                class="h-8 w-8 rounded-full object-cover"
                                            />
                                            <span v-else class="inline-block h-8 w-8 rounded-full overflow-hidden bg-gray-100">
                        <UserIcon class="h-full w-full text-gray-300" />
                      </span>
                                        </div>
                                    </div>
                                </button>
                            </template>

                            <template #content>
                                <div class="px-4 py-2">
                                    <div class="text-sm">{{ $page.props.auth.user?.name }}</div>
                                    <div class="text-xs text-gray-500">{{ $page.props.auth.user?.email }}</div>
                                </div>
                                <div class="border-t border-gray-100"></div>
                                <DropdownLink :href="route('profile.show')">Profile</DropdownLink>
                                <DropdownLink :href="route('logout')" method="post" as="button">Logout</DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </div>

            <main class="flex-1">
                <div class="py-6">
                    <!-- Flash Messages -->
                    <FlashMessage />

                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        <slot></slot>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
