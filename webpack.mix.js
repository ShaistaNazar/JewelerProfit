const mix = require('laravel-mix');
// require('laravel-mix-polyfill');

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
//  mix.webpackConfig({
//     resolve: {
//         modules: [
//             path.resolve(__dirname, 'vendor/laravel/spark/resources/assets/js')
//         ]
//     }
// });


mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');
    // .polyfill({
    //     enabled: true,
    //     useBuiltIns: "usage",
    //     targets: "firefox 50, IE 11"
    //  });;

    const NodePolyfillPlugin = require("node-polyfill-webpack-plugin")
    mix.webpackConfig({
        plugins: [
            new NodePolyfillPlugin(),
        ],
    
        resolve: {
            fallback: {
                fs: require.resolve('browserify-fs'),
            }
        }
    });
    
    mix.options({
            legacyNodePolyfills: false
    });    
