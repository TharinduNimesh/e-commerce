/** @type {import('tailwindcss').Config} */
export default {
  content: [],
  theme: {
    extend: {
      colors: {
        'primary-dark': '#17181B',
        'primary-dark-transparent': '#17181B77',
        'primary-light': '#F9FAFB',
        'primary-light-transparent': '#F9FAFB77',
        'secondary-dark': 'rgba(14, 16, 19)',
      }
    },
  },
  plugins: [require('@tailwindcss/typography'),],
}

