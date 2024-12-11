<!-- resources/js/Layouts/AdminLayout.vue -->
<template>
    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-primary text-white">
            <div class="p-6 text-lg font-bold">Admin Dashboard</div>
            <nav>
                <Link
                    href="/admin/restaurants"
                    class="block px-4 py-2 hover:bg-gray-700"
                >
                    Place Management
                </Link>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <slot />
        </div>
    </div>
</template>
<script setup>
import {Link} from "@inertiajs/vue3";
</script>
