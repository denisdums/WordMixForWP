/** @type {import('tailwindcss').Config} */
module.exports = {
  important: '#wordmix-admin-app',
  content: [
    './src/**/*.js',
    './src/**/*.jsx',
    './src/**/*.ts',
    './src/**/*.tsx',
    './src/**/*.php',
  ],
  theme: {
    extend: {},
  },
  plugins: [require("daisyui")],
}

