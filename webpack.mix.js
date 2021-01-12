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

/*-----------------------------*/
/*           BACKEND           */
/*-----------------------------*/

mix.scripts([
    'public/assets/plugins/jquery/jquery.min.js',
    'public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js',
    'public/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js',
    'public/assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js',
    'public/assets/plugins/sweetalert2/sweetalert2.min.js',
    'public/assets/plugins/toastr/toastr.min.js',
    'public/assets/dist/js/adminlte.min.js',
    'public/assets/dist/js/scripts.js',
    'public/assets/plugins/jquery-mousewheel/jquery.mousewheel.js',
    'public/assets/plugins/raphael/raphael.min.js',
    'public/assets/plugins/jquery-mapael/jquery.mapael.min.js',
    'public/assets/plugins/jquery-mapael/maps/usa_states.min.js',
    'public/assets/plugins/chart.js/Chart.min.js',
    'public/assets/dist/js/pages/dashboard2.js',
    'public/assets/custom/js/scripts.js',
], 'public/js/all.js');

mix.styles([
    'public/assets/plugins/fontawesome-free/css/all.min.css',
    'public/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css',
    'public/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
    'public/assets/plugins/toastr/toastr.min.css',
    'public/assets/dist/css/adminlte.min.css',
    'public/assets/custom/css/google-font.css',
], 'public/css/all.css');

mix.styles([
    'public/assets/css/style.css',
    'public/assets/css/uikit.css',
    'public/assets/css/icons.css',
], 'public/css/auth.css');

mix.scripts([
    'public/assets/js/uikit.js',
    'public/assets/js/simplebar.js',
], 'public/js/auth.js');

/*mix.copyDirectory('public/assets/fonts', 'public/fonts');
mix.copyDirectory('public/assets/plugins/fontawesome-free/webfonts', 'public/webfonts');
mix.copyDirectory('public/assets/dist/img', 'public/dist/img');*/

/*-----------------------------*/
/*           FRONTEND          */
/*-----------------------------*/
/**
 * Compiling CSS assets
 */
mix.styles([
    'public/assets/frontend/css/font-awesome.min.css',
    'public/assets/frontend/css/animate.css',
    'public/assets/frontend/css/icofonts.css',
    'public/assets/frontend/css/bootstrap.min.css',
    'public/assets/frontend/css/owlcarousel.min.css',
    'public/assets/frontend/css/magnific-popup.css',
    'public/assets/frontend/css/style.css',
    'public/assets/frontend/css/responsive.css',
    'public/assets/frontend/css/custom.css',
],'public/css/frontend.css')

/**
 * Compiling Js assets
 */
mix.scripts([
    'public/assets/frontend/js/jquery-2.0.0.min.js',
    'public/assets/frontend/js/popper.min.js',
    'public/assets/frontend/js/bootstrap.min.js',
    'public/assets/frontend/js/owl-carousel.2.3.0.min.js',
    'public/assets/frontend/js/waypoints.min.js',
    'public/assets/frontend/js/jquery.counterup.min.js',
    'public/assets/frontend/js/jquery.magnific.popup.js',
    'public/assets/frontend/js/smoothscroll.js',
    'public/assets/frontend/js/wow.min.js',
    'public/assets/frontend/js/main.js',
],'public/js/frontend.js')

/**
 * Copy assets resources
 */
mix.copyDirectory('public/assets/frontend/fonts', 'public/fonts');

mix.browserSync('lagenda.quebec.test')

mix.disableNotifications();
