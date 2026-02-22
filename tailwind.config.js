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
      fontFamily: {
        sans: ['Inter var', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  plugins: [require("daisyui")],
  daisyui: {
    themes: [
      {
        // Light Theme - Putih dengan blur
        lightElegant: {
          "primary": "#8B5CF6",        // Ungu violet
          "primary-content": "#FFFFFF",
          
          "secondary": "#EC4899",      // Pink fuchsia
          "secondary-content": "#FFFFFF",
          
          "accent": "#F43F5E",         // Merah rose
          "accent-content": "#FFFFFF",
          
          "neutral": "#1F2937",        // Abu gelap
          "neutral-content": "#F9FAFB",
          
          "base-100": "#FFFFFF",       // Background putih
          "base-200": "#F9FAFB",       // Surface abu sangat terang
          "base-300": "#F3F4F6",       // Border abu terang
          "base-content": "#111827",   // Text hitam
          
          "info": "#3B82F6",           // Biru
          "success": "#10B981",        // Hijau
          "warning": "#F59E0B",        // Kuning
          "error": "#EF4444",          // Merah error
        },
        
        // Dark Theme - Hitam dengan blur
        darkElegant: {
          "primary": "#A78BFA",        // Ungu lavender terang
          "primary-content": "#1F2937",
          
          "secondary": "#F472B6",      // Pink terang
          "secondary-content": "#1F2937",
          
          "accent": "#FB7185",         // Rose terang
          "accent-content": "#1F2937",
          
          "neutral": "#E5E7EB",        // Abu terang
          "neutral-content": "#111827",
          
          "base-100": "#0F1117",       // Background hitam kebiruan
          "base-200": "#1A1D29",       // Surface gelap
          "base-300": "#252A3A",       // Border gelap
          "base-content": "#F9FAFB",   // Text putih
          
          "info": "#60A5FA",           // Biru terang
          "success": "#34D399",        // Hijau terang
          "warning": "#FBBF24",        // Kuning terang
          "error": "#F87171",          // Merah terang
        },
      },
    ],
  },
}
