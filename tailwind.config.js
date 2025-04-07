import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
      ],
    
    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                quicksand: ['Quicksand', 'sans-serif'],
            },
            colors: {
                primary: {
                    light: '#3498db',
                    dark: '#2980b9',
                },
                secondary: {
                    light: '#2ecc71',
                    dark: '#27ae60',
                },
                background: {
                    light: '#f0f4f8',
                    dark: '#1a202c',
                },
                text: {
                    light: '#2c3e50',
                    dark: '#e2e8f0',
                },
            }
        },
    },

    plugins: [forms],
};
