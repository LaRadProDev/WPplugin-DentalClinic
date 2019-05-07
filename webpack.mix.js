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

mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.css$/,
                loaders: ['style-loader', 'css-loader']
            }
        ]
    }
});

mix.js('resources/assets/admin/js/app.js', 'static/admin/js/bundle.js')
   .sass('resources/assets/admin/scss/main.scss', 'static/admin/css/main.css', {
        outputStyle: 'compressed'
    }).options({
        processCssUrls: false
    });

mix.js('resources/assets/public/js/app.js', 'static/public/js/bundle.js');

mix.sass('resources/assets/public/scss/main.scss', 'static/public/css/main.css').options({
    processCssUrls: false
});


mix.copy( 'resources/assets/public/fonts', 'static/public/fonts', false );
mix.copy( 'resources/assets/public/img', 'static/public/img', false );