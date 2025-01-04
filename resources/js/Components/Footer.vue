<script setup>
import { Link } from '@inertiajs/vue3';

const navigation = {
    main: [
        { name: 'About', href: route('about') },
        { name: 'Blog', href: route('blog') },
        { name: 'Contact', href: route('contact') },
        { name: 'Terms', href: route('terms') },
        { name: 'Privacy', href: route('privacy') }
    ],
    social: [
        {
            name: 'Facebook',
            href: '#',
            icon: (props) => (
                <svg fill="currentColor" viewBox="0 0 24 24" {...props}>
                    <path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z" />
                </svg>
            )
        },
        {
            name: 'Instagram',
            href: '#',
            icon: (props) => (
                <svg fill="currentColor" viewBox="0 0 24 24" {...props}>
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                </svg>
            )
        },
        {
            name: 'Twitter',
            href: '#',
            icon: (props) => (
                <svg fill="currentColor" viewBox="0 0 24 24" {...props}>
                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                </svg>
            )
        }
    ]
};
</script>

<template>
    <footer class="bg-white">
        <div class="max-w-7xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
            <!-- Navigation -->
            <nav class="flex flex-wrap justify-center -mx-5 -my-2">
                <div v-for="item in navigation.main" :key="item.name" class="px-5 py-2">
                    <Link :href="item.href" class="text-base text-gray-500 hover:text-gray-900">
                        {{ item.name }}
                    </Link>
                </div>
            </nav>

            <!-- Social Links -->
            <div class="mt-8 flex justify-center space-x-6">
                <a
                    v-for="item in navigation.social"
                    :key="item.name"
                    :href="item.href"
                    class="text-gray-400 hover:text-gray-500"
                >
                    <span class="sr-only">{{ item.name }}</span>
                    <component :is="item.icon" class="h-6 w-6" aria-hidden="true" />
                </a>
            </div>

            <!-- Download App -->
            <div class="mt-8 flex justify-center space-x-4">
                <a href="#" class="flex items-center">
                    <img src="/images/app-store.svg" alt="Download on App Store" class="h-10">
                </a>
                <a href="#" class="flex items-center">
                    <img src="/images/google-play.svg" alt="Get it on Google Play" class="h-10">
                </a>
            </div>

            <!-- Copyright -->
            <p class="mt-8 text-center text-base text-gray-400">
                © {{ new Date().getFullYear() }} Your Company, Inc. All rights reserved.
            </p>

            <!-- Additional Links -->
            <div class="mt-4 flex justify-center space-x-4 text-sm text-gray-400">
                <Link :href="route('terms')" class="hover:text-gray-500">Terms</Link>
                <span>·</span>
                <Link :href="route('privacy')" class="hover:text-gray-500">Privacy</Link>
                <span>·</span>
                <Link :href="route('cookies')" class="hover:text-gray-500">Cookies</Link>
            </div>
        </div>
    </footer>
</template>
