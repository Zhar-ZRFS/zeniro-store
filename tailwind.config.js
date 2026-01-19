/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        // Warna Utama zeniroStore
        primary: {
          primaryBlue: '#051F3D',  // Biru Gelap
          primaryPink: '#E8A9B1',     // Pink Lembut (Second Primary)
        },
        secondary: '#D7EBF7',  // Biru Sangat Muda
        
        // Aksen
        accent: {
          blue: '#5893D5',     // Biru Aksen
          pink: '#F0D7D9',     // Pink Aksen
          bluesoft: '#99BBE2',
        },
        
        // Utilitas & Netral
        white: '#FAFAFA',      // Putih agak abu dikit (soft)
        gray: '#AEAEAE',
        black: '#121212',
        
        // Warna Merah Custom
        danger: {
          50: '#F5E8E8',
          500: '#D55858',
          600: '#C24141',
          700: '#9E3535',
        },
      },
      fontFamily: {
        // Font Lato untuk body/paragraf (set sebagai default sans)
        sans: ['Lato', 'sans-serif'], 
        // Font Montserrat untuk Heading
        heading: ['Montserrat', 'sans-serif'],
      },
    },
  },
  plugins: [],
}