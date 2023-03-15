const mix = require('laravel-mix');

require('laravel-mix-tailwind');

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

   .babel(['resources/js/fitvids.js'], 'public/js/fitvids.js')

   .babel(['resources/js/perfect-scrollbar.js'], 'public/js/perfect-scrollbar.js')

   .postCss('resources/css/app.css',
            'public/css')

   .scripts(['resources/js/owl.carousel.js'], 'public/js/owl.carousel.js')

   .styles(['resources/css/owl.carousel.css', 'resources/css/owl.theme.default.css'],
            'public/css/owl.carousel.css')

   .styles(['resources/css/perfect-scrollbar.css'],
            'public/css/perfect-scrollbar.css')

   .tailwind('./tailwind.config.js')
   .version()
   .sourceMaps();

if (mix.inProduction()) {
  mix
   .version();
}
