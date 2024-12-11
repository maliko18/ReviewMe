import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary': '#004d45',
                'secondary': '#FF9800',
                'accent': '#FF5722',
                'dark': '#212121',
                'light': '#F5F5F5',
                'success': '#4CAF50',
                'info': '#2196F3',
                'warning': '#FFC107',
                'error': '#FF5722',
            },
        },
    },

    plugins: [forms, typography],
};
