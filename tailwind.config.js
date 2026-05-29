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
                    DEFAULT: '#c8102e',
                    dark: '#9b0d23',
                },
                accent: '#e63950',
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
