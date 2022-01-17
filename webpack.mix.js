const mix = require('laravel-mix')
const path = require('path')
require('laravel-mix-workbox')

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

mix
  .js('resources/js/app.js', 'public/js')
  .postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
  ])

mix
  .webpackConfig({
    output: {
      publicPath: '',
    },
  })
  .generateSW({
    swDest: path.join(`${__dirname}/public`, 'sw.js'),

    exclude: [/\.(?:png|jpg|jpeg|svg|webp|js|css)$/, 'mix.js'],

    runtimeCaching: [
      {
        urlPattern: new RegExp(`${process.env.APP_URL}`),
        handler: 'NetworkFirst',
        options: {
          cacheName: `${process.env.APP_NAME}-${process.env.APP_ENV}`,
        },
      },
      {
        urlPattern: /\.(?:png|jpg|jpeg|svg|webp)$/,
        handler: 'CacheFirst',
        options: {
          cacheName: 'images',
        },
      },
      {
        urlPattern: /\.(?:js|css)$/,
        handler: 'CacheFirst',
        options: {
          cacheName: 'js-css',
        },
      },
    ],

    clientsClaim: true,

    skipWaiting: true,

    mode: 'production',
  })
