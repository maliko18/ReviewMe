<!-- resources/js/Components/AppFooter.vue -->
<template>
    <footer class="bg-black text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-4 gap-8 justify-center ">

                <!-- About Links -->
                <div>
                    <Link v-for="link in aboutLinks"
                          :key="link.href"
                          :href="link.href"
                          class="block mb-3 hover:text-gray-300">
                        {{ link.text }}
                    </Link>
                </div>

                <!-- Program Links -->
                <div>
                    <Link v-for="link in programLinks"
                          :key="link.href"
                          :href="link.href"
                          class="block mb-3 hover:text-gray-300">
                        {{ link.text }}
                    </Link>
                </div>

                <!-- Social & Copyright -->
                <div class="flex flex-col justify-between">
                    <div class="flex items-center gap-4">
                        <a href="#" class="text-white hover:text-gray-300">
                            <InstagramIcon class="w-6 h-6" />
                        </a>
                        <SwitchTheme />
                    </div>
                </div>
            </div>

        </div>
    </footer>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { InstagramIcon } from 'lucide-vue-next'
import SwitchTheme from './SwitchTheme.vue'

const aboutLinks = [
    { href: '', text: 'A propos' },
    { href: '', text: 'Contact' },
    { href: '', text: 'Foire aux Questions' },
    { href: '', text: 'Mentions légales (Impressum)' },
    { href: '/blog', text: 'Blog' },
]

const programLinks = [
    { href: '', text: 'Programme fidélité' },
    { href: '', text: 'Conditions d\'utilisation' },
    { href: '', text: 'Confidentialité et utilisation des cookies' },
    { href: '', text: 'Accord d\'utilisation des cookies' },
    { href: '', text: 'Nous recrutons' },
    { href: '', text: 'Partenariat Guide MICHELIN' },
    { href: '', text: 'Cartes cadeaux TheFork' }
]
</script>
