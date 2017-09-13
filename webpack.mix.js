let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js/bundle.js')
   .js('resources/assets/js/nos-sdk-v4.js', 'public/js/nos.js')
   .sass('resources/assets/sass/app.scss', 'public/css/bundle.css')
   .sass('resources/assets/sass/timeline.scss','public/css/timeline.css');
