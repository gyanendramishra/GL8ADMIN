const path = require('path')
const mix = require('laravel-mix')
const cssImport = require('postcss-import')
const cssNesting = require('postcss-nesting')
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


mix
  .js('resources/js/app/app.js', 'public/assets/app/js')
  .js('resources/js/admin/app.js', 'public/assets/admin/js')
  .vue()
  .postCss('resources/css/app/app.css', 'public/assets/app/css', [
    // prettier-ignore
    cssImport(),
    cssNesting(),
    require('tailwindcss'),
  ])
  .postCss('resources/css/admin/app.css', 'public/assets/admin/css', [
    // prettier-ignore
    cssImport(),
    cssNesting(),
    require('tailwindcss'),
  ])
  .webpackConfig({
    output: {
      chunkFilename: 'assets/chunks/[name].js?id=[chunkhash]'
    },
    resolve: {
      alias: {
        vue$: 'vue/dist/vue.runtime.esm.js',
        '@app': path.resolve('resources/js/app'),
        '@admin': path.resolve('resources/js/admin'),
      },
    },
  })
  .version()
  .sourceMaps()

