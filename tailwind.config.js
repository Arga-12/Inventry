/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    safelist: [
        // Badge status
        'bg-yellow-100', 'text-yellow-600', 'border-yellow-200',
        'bg-blue-100', 'text-blue-600', 'border-blue-200',
        'bg-orange-100', 'text-orange-700', 'border-orange-200', // ← TAMBAHKAN INI
        'bg-red-100', 'text-red-600', 'border-red-200',
        'bg-green-100', 'text-green-600', 'border-green-200',
        'bg-gray-200', 'text-gray-700', 'border-gray-300',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Jost", "ui-sans-serif", "system-ui"],
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
};
