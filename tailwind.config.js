import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    // TAMBAHKAN BARIS INI
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js'
    ],

    theme: {
        container: {
            center: true,
            padding: {
                DEFAULT: '1rem',
                sm: '2rem',
                lg: '4rem',
            },
        },
        extend: {
            colors: {
                brand: {
                    DEFAULT: '#f97316',
                    50: '#fff7ed',
                    100: '#fff0e6',
                    200: '#ffd3b3',
                    300: '#ffb680',
                    400: '#ff974d',
                    500: '#f97316',
                    600: '#ea580c',
                    700: '#c2410c',
                    800: '#9a3412',
                    900: '#7c2d12'
                }
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Playfair Display', ...defaultTheme.fontFamily.serif]
            },
            boxShadow: {
                'soft-xl': '0 10px 30px rgba(15, 23, 42, 0.06)'
            }
        },
    },

    plugins: [forms],
};
