import { light } from '@fortawesome/fontawesome-svg-core/import.macro';
import colors from 'tailwindcss/colors';
import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  darkMode: 'class',
  theme: {
    fontFamily: {
      satoshi: ['Satoshi', 'sans-serif']
    },
    screens: {
      '2xsm': '375px',
      xsm: '425px',
      '3xl': '2000px',
      ...defaultTheme.screens
    },
    extend: {
      colors: {
        main: {
          DEFAULT: '#ddd',
          dark: '#111120'
        },
        background: {
          DEFAULT: '#FFFFFF',
          dark: '#212333'
        },
        sidebar: {
          DEFAULT: '#FEFEFE',
          hover: '#FEEFEE',
          dark: {
            DEFAULT: '#212333',
            hover: '#111'
          },
          border: {
            DEFAULT: '#ddd',
            dark: '#111'
          }
        },
        dark: {
          DEFAULT: '#011',
          50: '#122',
        },
        light: {
          DEFAULT: '#ddd',
          50: '#DDD'
        },
        input: {
          DEFAULT: '#eee',
          dark: '#111120'
        },
        primary: {
          DEFAULT: '#053861',
          hover: '#03213A',
        },
        link: {
          DEFAULT: '#66f',
          hover: '#33f'
        },
        danger: {
          DEFAULT: '#600'
        }
      },
      fontFamily: {
        sans: ['Roboto', 'sans-serif'], // Define Roboto como fuente principal
      },
    }
  },
  plugins: []
}
