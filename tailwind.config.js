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
      colors: {
        // Portail RH Brand Colors
        primary: {
          50: '#E8F4FD',
          100: '#D1E9FB',
          200: '#A3D3F7',
          300: '#75BDF3',
          400: '#5BA3E8',
          500: '#4A90D9',  // Couleur principale Portail RH
          600: '#3A7BC8',
          700: '#2E6BB3',  // Couleur foncée Portail RH
          800: '#235A9E',
          900: '#1A4A89',
          950: '#0F2F5A',
        },
        // Orange Vif Portail RH - Couleur d'accent principale
        accent: {
          50: '#FFF8F0',
          100: '#FFE5BF',
          200: '#FFD699',
          300: '#FFC266',
          400: '#FF9500',  // Orange Vif Portail RH - Principal
          500: '#FF6B00',  // Orange Vif Portail RH - Foncé
          600: '#E65C00',
          700: '#CC4D00',
          800: '#993A00',
          900: '#662600',
          950: '#331300',
        },
        // Vert succès Portail RH
        success: {
          50: '#E8F8EF',
          100: '#D1F1DF',
          200: '#A3E3BF',
          300: '#75D59F',
          400: '#2ECC71',
          500: '#27AE60',  // Vert Portail RH
          600: '#1E8449',
          700: '#186A3B',
          800: '#145A32',
          900: '#0E4023',
          950: '#072615',
        },
        // Gris neutre Portail RH
        neutral: {
          50: '#F8FAFA',
          100: '#F1F5F5',
          200: '#E3EBEB',
          300: '#C7D6D6',
          400: '#95A5A6',
          500: '#7F8C8D',  // Gris Portail RH
          600: '#6B7B7C',
          700: '#566566',
          800: '#424F50',
          900: '#2D3939',
          950: '#1A2222',
        },
      },
      fontFamily: {
        sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'],
      },
      boxShadow: {
        'soft': '0 2px 8px rgba(0, 0, 0, 0.04)',
        'medium': '0 4px 16px rgba(0, 0, 0, 0.08)',
        'strong': '0 8px 24px rgba(0, 0, 0, 0.12)',
      },
      animation: {
        'fade-in': 'fadeIn 0.3s ease-in-out',
        'slide-in': 'slideIn 0.3s ease-out',
        'scale-in': 'scaleIn 0.2s ease-out',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideIn: {
          '0%': { transform: 'translateY(-10px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        scaleIn: {
          '0%': { transform: 'scale(0.95)', opacity: '0' },
          '100%': { transform: 'scale(1)', opacity: '1' },
        },
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
