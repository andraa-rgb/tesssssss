import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        // Custom Dark Orange Palette
        'dark': {
          50: '#2A2A2E',
          100: '#1F1F23',
          200: '#18181B',
          300: '#121214',
          400: '#0D0D0F',
          500: '#08080A',
        },
        'orange': {
          50: '#FFF7ED',
          100: '#FFEDD5',
          200: '#FED7AA',
          300: '#FDBA74',
          400: '#FB923C',
          500: '#F97316', // Primary
          600: '#EA580C',
          700: '#C2410C',
          800: '#9A3412',
          900: '#7C2D12',
        },
      },
    },
  },
  plugins: [require("daisyui")],
  daisyui: {
    themes: [
      {
        darkOrange: {
          "primary": "#F97316",     // Orange-500
          "primary-content": "#FFFFFF",
          "secondary": "#FB923C",   // Orange-400
          "secondary-content": "#FFFFFF",
          "accent": "#FDBA74",      // Orange-300
          "accent-content": "#18181B",
          "neutral": "#1F1F23",     // Dark-100
          "neutral-content": "#E5E5E5",
          "base-100": "#18181B",    // Dark-200 (Background utama)
          "base-200": "#121214",    // Dark-300 (Card/surface)
          "base-300": "#0D0D0F",    // Dark-400 (Borders)
          "base-content": "#E5E5E5", // Text color
          "info": "#3B82F6",
          "success": "#10B981",
          "warning": "#F59E0B",
          "error": "#EF4444",
        },
      },
    ],
  },
}

