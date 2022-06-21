const mix = require("laravel-mix")

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
  .css("resources/css/sheets-of-paper.css", "public/css")
  .js("resources/js/app.js", "public/js")
  .vue({
    extractStyles: true,
  })
  .postCss("resources/css/app.css", "public/css", [
    require("postcss-import"),
    require("tailwindcss"),
    require("autoprefixer"),
  ])
  .webpackConfig(require("./webpack.config"))
  .extract()
  .disableSuccessNotifications()

if (mix.inProduction()) {
  mix.version()
    .webpackConfig({
      output: {
        publicPath: "/stie/"
      }
    })
} else {
  mix.sourceMaps().webpackConfig({
    devtool: "inline-source-map",
  })
}
