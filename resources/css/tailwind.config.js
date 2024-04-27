module.exports = {
  content: [
    './components/**/*.{php,js,css}',
    './templates/**/*.php',
    './lib/**/*.php',
    './resources/**/*.{js,css}',
    './search.php',
    './index.php',
    './base.php',
    './404.php',
    /*
     * Include files that have css classes that need to be rendered
     * Files and folders that don't exist should not be included
     * Below you will see some examples of files/paths that are not included and why and when to include them
     */
    // './page.php', // Include this line if you end up adding markup with classes to file
    // './single.php', // Include this line if you end up adding markup with classes to the file
    // './woocommerce/**/*.php', // Include this line if you end up adding woocommerce file overrides
    // './functions.php', // This file is not neccessary to include since it only holds references to all the other functions
    // './*.php', DO NOT INCLUDE THIS LINE
  ],
  safelist: [
    {
      pattern: /object-.+/
    },
    {
      pattern: /(my|mb|mt|mx|py|pb|pt|px)-.+/,
      variants: ['sm', 'md', 'lg', 'xl'],
    },
    {
      pattern: /w-\d{1,2}\/\d{1,2}/,
      variants: ['sm', 'md', 'lg', 'xl'],
    },
    {
      pattern: /w-.+/,
    },
    {
      pattern: /h-.+/,
    },
    /* To safelist more classes such as text color or background color use something like below, if not using bg-brand or text-brand and opting for text- or bg- keep in mind this whitelists classes such as bg-opacity, text-xl etc. */
    /* {
      pattern: /bg-brand-.+/
    } */
  ],
  theme: {
    colors: {
      inherit: 'inherit',
      current: 'currentColor',
      transparent: 'transparent',
      black: '#000',
      white: '#fff',
      brand: {
        'jet': '#343434',
        'gold': '#9d8420',
        'ivory': '#FEFFF0',
        'rust': '#CA4A00',

        'highlight': '#DDDDD',
        'primary': '#5FB0C8',
        'light-gray': '#BEBEBE',
        'dark-gray': '#443E51',
        'scrim': 'rgba(0,0,0,0.8)', // you can use bg-black and bg-opacity-80 as an alternative to a custom scrim color
        'overlay': 'rgba(255,255,255,0.35)', // you can use bg-white and bg-opacity-35 as an alternative to a custom overlay color
      },
      gray: {
        100: '#f7fafc',
        200: '#edf2f7',
        300: '#e2e8f0',
        400: '#cbd5e0',
        500: '#a0aec0',
        600: '#718096',
        700: '#4a5568',
        800: '#2d3748',
        900: '#1a202c',
      },
      form: {
        'placeholder': '#777777',
        'description': '#9C9C9C',
        'error': '#FF5454',
        'focus': '#5A56F9',
        'radio-button-unchecked': '#4B4DED',
        'radio-button-checked': '#0500D7',
        'toggle-unchecked': '#EFEFFD',
        'toggle-checked': '#928FFF',
      },
      button: {
        DEFAULT: '#4B4DED',
        'hover': '#0500D7',
      }
    },
    fontFamily: {
      sans: [
        'Teko',
        'sans-serif',
        '"Apple Color Emoji"',
        '"Segoe UI Emoji"',
        '"Segoe UI Symbol"',
        '"Noto Color Emoji"',
      ]
    },
    fontSize: {
      xs: 12 / 16 + 'rem',
      sm: 14 / 16 + 'rem',
      base: 16 / 16 + 'rem',
      lg: 18 / 16 + 'rem',
      xl: 20 / 16 + 'rem',
      '2xl': 24 / 16 + 'rem',
      '3xl': 32 / 16 + 'rem',
      '4xl': 40 / 16 + 'rem',
      '5xl': 48 / 16 + 'rem',
      '6xl': 64 / 16 + 'rem',
      '7xl': 80 / 16 + 'rem',
      '8xl': 96 / 16 + 'rem',
    },
    lineHeight: {
      none: '1',
      tight: '1.25',
      snug: '1.375',
      normal: '1.5',
      relaxed: '1.625',
      loose: '2',
    },
    letterSpacing: {
      tighter: '-0.05em',
      tight: '-0.025em',
      normal: '0',
      wide: '0.025em',
      wider: '0.05em',
      widest: '0.1em',
    },
    screens: {
      sm: '640px',
      md: '768px',
      lg: '1024px',
      xl: '1270px',
    },
    container: {
      center: true,
      padding: {
        DEFAULT: 'calc( var(--gutter) * 2 )',
        // lg: '3.125rem', // 50px
        lg: '1.125rem',
      }
    },
    extend: {
      spacing: {
        gutter: 'var(--gutter, 1rem )', // 16px
        'gutter-full': 'calc( var(--gutter) * 2 )', //32px
        '18': '4.5rem', // 72px
      },
      // this section allows you to add more style class options without overwriting all the options for a single style option (for example the z-index and adding -1). You can reference tailwindcss version 3.1.7 docs to see how to extend specific config options not included below
      zIndex: {
        '-1': '-1'
      },
      backgroundImage: {
        // 'gradient-fade-tr': 'linear-gradient(71.24deg, #000000 20.76%, rgba(0, 0, 0, 0) 100%)', // custom gradient example. Usuage would be bg-gradient-fade-tr
      },
      boxShadow: {
        'form-focus': '0px 0px 0px 4px rgba(0, 0, 0, 0.25)',
      }
    },
  },
}
