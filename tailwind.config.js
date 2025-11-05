/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#D16806',
        secondary: '#F9F6F3',
        dark: '#353535',
        black: '#1A1A1A',
        gray: {
          DEFAULT: '#777F81',
          100: '#EAE5DD',
          300: '#DCDCDC',
        },
        light: '#fdfdfd',
      },
      fontFamily: {
        heading: ['Cormorant Upright', 'serif'],
        body: ['Sora', 'sans-serif'],
      },
      spacing: {
        'padding-side': '6rem',
      },
    },
  },
  plugins: [],
}

