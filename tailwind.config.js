module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
        colors: {
            'dark-grey': '#212a34',
            'pink': '#d052a5',
            'orange': '#d07247',
            'blue': '#4a90e2',
            'grey': '#b4b4b4',
        },
        fontFamily: {
            sans: 'Roboto, sans-serif',
            headline: 'Poppins, sans-serif',
        },
        container: {
            screens: {
               lg: '1100px',
               xl: '1110px'
            }
        },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
