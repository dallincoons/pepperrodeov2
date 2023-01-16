let mix = require('laravel-mix');
var path = require('path');

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

const homedir = require('os').homedir();

mix.less('resources/assets/less/app.less', 'public/css')
    .copy('node_modules/sweetalert/dist/sweetalert.min.js', 'public/js/sweetalert.min.js')
    .copy('node_modules/sweetalert/dist/sweetalert.css', 'public/css/sweetalert.css')
    .js('resources/assets/js/app.js', 'public/js')
    .sourceMaps()
    .vue()
    .copy('resources/assets/img', 'public/img', false)
    .browserSync({
        port: 3000,
        proxy: 'https://pepperrodeov2.test',
        host: 'pepperrodeov2.test',
        open: 'external',
        https: {
            key: homedir + '/.config/valet/Certificates/pepperrodeov2.test.key',
            cert: homedir + '/.config/valet/Certificates/pepperrodeov2.test.crt',
        },
    })
    .webpackConfig({
        resolve: {
            modules: [
                path.resolve(__dirname, 'vendor/laravel/spark/resources/assets/js'),
                'node_modules'
            ],
            alias: {
                'vue$': 'vue/dist/vue.js'
            }
        }
   })
   .version();
