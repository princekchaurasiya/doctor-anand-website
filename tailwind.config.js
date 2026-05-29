/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/js/**/*.{js,ts,tsx}',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: '#5B2D8C',
                    dark: '#4A2370',
                },
                accent: '#E8B923',
            },
            borderRadius: {
                brand: '10px',
            },
            maxWidth: {
                container: '1200px',
            },
        },
    },
    plugins: [],
};
