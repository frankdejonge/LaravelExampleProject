let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');
var atImport = require("postcss-import");

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

mix.js('resources/assets/js/app.js', 'public/js')
    .sourceMaps();
mix.sass('resources/assets/sass/app.scss', 'public/css');
mix.postCss('resources/assets/css/index.css', 'public/css', [
    atImport(),
    tailwindcss('./tailwind.js'),
]);
