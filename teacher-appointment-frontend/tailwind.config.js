/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",],
  theme: {
    extend: {
       colors: {
        primary: '#2563EB',
        secondary: '#4B5563',
        accent: '#10B981',
        'bg-light': '#F9FAFB',
        error: '#EF4444',
      },
    },
  },
  plugins: [],
}

