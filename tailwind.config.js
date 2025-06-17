import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources//*.blade.php",
        "./resources//*.js",
        "./resources//*.vue",
        "./vendor/laravel/jetstream//*.blade.php",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Roboto', 'sans-serif'],
            },
            colors: {
        primary: '#c98500',
        secondary: '#64748b',
        accent: '#f59e42',
        info: {
          200: '#90F2DB',
          300: '#56DAC5',
        },
      },
        },
    },
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};