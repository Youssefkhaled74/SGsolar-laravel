/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  darkMode: 'class', // Enable dark mode with class strategy
  theme: {
    extend: {
      colors: {
        brand: {
          yellow: '#FFDF41',
          orange: '#E3A000',
          dark: '#0C2D1C',
          forest: '#115F45',
          light: '#8CC63F',
        },
      },
    },
  },
  plugins: [],
}
