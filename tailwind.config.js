import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            "colors": {
                "primary": "#427AB5",
                "primary-dark": "#406AAF",
                "primary-light": "#D6E6F7",
                "accent": "#F7DD7D",
                "accent-light": "#FFE8BE",
                "accent-dark": "#E8C84A",
                "success": "#4CAF7D",
                "warning": "#FF9B42",
                "danger": "#F25C5C",
                "background": "#FFFDF7",
                "bg-secondary": "#FFF6E5",
                "text-primary": "#1E1E2E",
                "text-secondary": "#5A5A7A",
                "text-muted": "#9898B0",
                "border": "#E8E0F0",
            },
            "borderRadius": {
                "DEFAULT": "1rem",
                "lg": "2rem",
                "xl": "3rem",
                "2xl": "4rem",
                "full": "9999px",
            },
            "fontFamily": {
                "sans": ["Plus Jakarta Sans", ...defaultTheme.fontFamily.sans],
                "heading": ["Fredoka", ...defaultTheme.fontFamily.sans],
                "hand": ["Gochi Hand", "cursive"],
            },
        },
    },

    plugins: [forms],
};
