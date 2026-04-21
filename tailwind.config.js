const plugin = require('tailwindcss/plugin');

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./themes/**/templates/**/*.html.twig",
    "./templates/**/*.html.twig",
    "./vendor/mcsupply/ecommerce-bundle/templates/**/*.html.twig",
    "./vendor/mcsupply/ecommerce-bundle/src/Twig/Components/**/*.php",
    "./bundles/ecommerce-bundle/src/Twig/Components/**/*.php",
    "./bundles/ecommerce-bundle/templates/**/*.html.twig",
  ],
  safelist: [
    'lg:grid-cols-[1fr_3fr]',
    'lg:grid-cols-[3fr_1fr]',
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
