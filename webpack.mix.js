const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/stpronk.js', 'public/js')
   .js('resources/js/assignments/dealer/app.js', 'public/js/dealer.js')
    .js('resources/js/assignments/eventPlanner/app.js', 'public/js/eventPlanner.js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/stpronk.scss', 'public/css')
    .sass('resources/sass/auth.scss', 'public/css')
    .copy('resources/fonts', 'public/fonts')
    .copy('resources/images', 'public/images');
