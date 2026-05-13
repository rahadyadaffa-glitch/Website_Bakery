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
                "primary": "#8e4e14",
                "primary-dark": "#6f3800",
                "primary-light": "#ffdcc4",
                "secondary": "#366758",
                "accent": "#f4a261",
                "accent-light": "#ffb780",
                "accent-dark": "#e76f51",
                "success": "#366758",
                "warning": "#f4a261",
                "danger": "#ba1a1a",
                "background": "#fff8ef",
                "bg-secondary": "#fbf3e4",
                "text-primary": "#1e1b13",
                "text-secondary": "#534439",
                "text-muted": "#867468",
                "border": "#d8c2b5",
            },
            "borderRadius": {
                "DEFAULT": "1rem",
                "lg": "2rem",
                "xl": "3rem",
                "2xl": "4rem",
                "full": "9999px",
            },
            "spacing": {
                "margin-desktop": "40px",
                "margin-mobile": "16px",
                "gutter": "24px",
                "unit": "8px",
                "container-max": "1200px"
            },
            "fontFamily": {
                "sans": ["Plus Jakarta Sans", ...defaultTheme.fontFamily.sans],
                "heading": ["Fredoka", ...defaultTheme.fontFamily.sans],
                "hand": ["Gochi Hand", "cursive"],
                "hand-drawn": ["Caveat", "cursive"],
            },
        },
    },

    plugins: [forms],
};
