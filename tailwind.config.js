module.exports = {
  content: [
    "./*.php",
    "./template-parts/**/*.php",
    "./assets/js/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#022F3E',
        'primary-light': '#00566e',
        secondary: {
          golden: '#FFD700',
          green: '#00B894',
        },
      },
    },
  },
  plugins: [],
}

