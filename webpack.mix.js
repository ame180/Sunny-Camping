const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js([
    'resources/js/app.js',
    'resources/js/all.js',
    'resources/js/bootstrap.min.js',
], 'public/js/app.js')
    .js('resources/js/parallax.min.js', 'public/js/parallax.min.js')
    .js('resources/js/script.js', 'public/js/script.js')
    .styles([
        'resources/css/bootstrap.min.css',
        'resources/css/all.css',
        'resources/css/admin/clients.css',
    ], 'public/css/app.css')
    .styles('resources/css/style.css', 'public/css/style.css');
