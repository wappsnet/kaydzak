'use strict'

const path = require('path');
const autoprefixer = require('autoprefixer');
const miniCssExtractPlugin = require('mini-css-extract-plugin')

module.exports = {
  mode: 'development',
  entry: [
    path.resolve(__dirname, 'assets', 'script.js'),
    path.resolve(__dirname, 'assets', 'style.scss'),
    path.resolve(__dirname, 'plugins', 'style.scss'),
    path.resolve(__dirname, 'modules', 'style.scss'),
    path.resolve(__dirname, 'layouts', 'style.scss'),
  ],
  output: {
    filename: 'main.js',
    path: path.resolve(__dirname, 'build')
  },
  performance: {
    hints: false,
    maxEntrypointSize: 512000,
    maxAssetSize: 512000
  },
  devServer: {
    static: path.resolve(__dirname, 'build'),
    port: 8080,
    hot: true
  },
  plugins: [
    new miniCssExtractPlugin({
      filename: '[name].css',
      chunkFilename: '[id].css',
    }),
  ],
  module: {
    rules: [
      {
        test: /\.(scss)$/,
        use: [
          {
            // Adds CSS to the DOM by injecting a `<style>` tag
            loader: miniCssExtractPlugin.loader
          },
          {
            // Interprets `@import` and `url()` like `import/require()` and will resolve them
            loader: 'css-loader'
          },
          {
            // Loader for webpack to process CSS with PostCSS
            loader: 'postcss-loader',
            options: {
              postcssOptions: {
                plugins: [
                  autoprefixer
                ]
              }
            }
          },
          {
            // Loads a SASS/SCSS file and compiles it to CSS
            loader: 'sass-loader',
          }
        ]
      }
    ]
  }
}