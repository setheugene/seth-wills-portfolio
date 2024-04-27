let mix = require('laravel-mix');

const globby = require('globby');
const ESLintPlugin = require('eslint-webpack-plugin');

mix.options({
  processCssUrls: false,
  terser: {
    extractComments: false,
  }
});

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

/*
 |--------------------------------------------------------------------------
 | Scripts
 |--------------------------------------------------------------------------
 |
 |
 */
mix.webpackConfig({
  externals: {
    "jquery": "jQuery"
  },
});

mix.setPublicPath('assets/');

/*
 * Front End Pipeline
 */

if (!process.argv.includes('--watch-admin')) {
  $scripts = globby.sync(['resources/js/app.js', 'resources/js/_*.js', 'components/*/*.js']);
  $vendor_scripts = [
    'resources/js/vendor/easy-toggle-state.js',
    'node_modules/magnific-popup/dist/jquery.magnific-popup.js',
    'node_modules/slick-carousel/slick/slick.min.js',
  ];

  mix.postCss('resources/css/reset.css', 'css/reset.min.css').sourceMaps();
  mix.postCss('resources/css/app.css', 'css/main.min.css').sourceMaps();

  mix.js($scripts, 'js/scripts.min.js').sourceMaps();
  mix.js($vendor_scripts, 'js/vendor.min.js');
}

/*
 * Admin / Editor Pipeline
 */
if (!process.argv.includes('--watch-front')) {

  mix.postCss('resources/admin/admin.css', 'css/admin.min.css');

  mix.postCss('resources/admin/editor-style.css', 'css/editor-style.css').sourceMaps();

  mix.js('resources/admin/admin.js', 'js/admin.min.js').sourceMaps();
}

mix.version();

mix.webpackConfig({
  plugins: [new ESLintPlugin(
    {
      fix: true,
    }
  )],
});
