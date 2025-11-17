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
    .sass('resources/sass/app.scss', 'public/css')
    .scripts(['resources/js/jquery.form.min.js', 'resources/js/jquery.mask.min.js'],'public/js/theme.js')
    .copy('resources/js/progress.js','public/js/progress.js')
    .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts');
