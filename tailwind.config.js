const plugin = require('tailwindcss/plugin');

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./themes/**/templates/**/*.html.twig",
    "./templates/**/*.html.twig",
    "./src/Twig/Components/**/*.php",
    "./vendor/tales-from-a-dev/flowbite-bundle/templates/**/*.html.twig",
  ],
  darkMode: 'media',
  theme: {
    extend: {
      animation: {
        'fade-in': 'fadeIn .5s ease-out;',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: 0 },
          '100%': { opacity: 1 },
        },
      },
    },
  },
  plugins: [],
}
