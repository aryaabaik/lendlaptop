/** @type {import('tailwindcss').Config} */
export default {
    content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'primary-teal': '#0D9F7A',
        'navy-navbar': '#0A1628',
        'status-blue': '#2563EB', // For 'dipinjam' status
        'status-amber': '#F59E0B', // For 'Menunggu Konfirmasi' and amber progress
        'status-red': '#EF4444', // For red progress
            },
      fontFamily: {
        inter: ['Inter', 'sans-serif'],
        },
    },
  },
  plugins: [],
};
