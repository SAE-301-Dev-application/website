/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      "./src/Resources/Css/**/*.css",
      "./src/Views/**/*.php",
  ],
  theme: {
    extend: {
      colors: {
        "orange": "#FF7A00",
        "orange-light": "#FFCEA1",
        "white": "#FFFFFF",
        "blue": "#0094FF",
        "grey": "#686868",
        "grey-light": "#E6E6E6",
        "red": "#FB0D0D",
        "green": "#00C637"
      },

      aspectRatio: {
        "illustration": "4/3",
      },
    },
  },
  plugins: [],
}

