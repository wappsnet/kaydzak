const webpack = require('webpack');
const path = require('path');
const fs = require('fs');
const UglifyJsPlugin = require("uglifyjs-webpack-plugin");
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const { CleanWebpackPlugin } = require("clean-webpack-plugin");
const WebpackOnBuildPlugin = require("on-build-webpack");
const WebpackIncludes = require("./webpack");

require('es6-promise').polyfill();

const theme_path = __dirname + '\\wp-content\\themes\\wappsnet\\';

module.exports = [
    {
        mode: "development",
        name: "js",
        entry: {
            "app": theme_path + "assets\\js\\index.js"
        },

        output: {
            path: theme_path + "assets\\build\\wappsnet",
            filename: "[name].min.js"
        },

        module: {
            rules:[{
                test: /\.js?$/,
                loader: 'babel-loader'
            }]
        },

        resolve: {
            alias:{
                modules: path.resolve(theme_path + 'modules'),
                plugins: path.resolve(theme_path + 'plugins'),
                utils:   path.resolve(theme_path + 'assets\\js\\modules')
            }
        },

        plugins: [
            new WebpackIncludes(),

            new webpack.ProvidePlugin({
                $: "jquery",
                jQuery: "jquery", "window.jQuery": "jquery",
                PubSub: "pubsub-js",
                Materialize: theme_path + "assets\\js\\partials\\materialize.js",
                noUiSlider: theme_path + "assets\\js\\partials\\nouislider.js",
                stickyScroll: theme_path + "assets\\js\\partials\\sticky-scroll.js",
                hammerjs: "hammerjs",
                Hummer: "hammerjs"
            })
        ],

        optimization: {
            minimizer: [new UglifyJsPlugin()]
        }
    },
    {
        mode: "development",
        name: "css",
        entry: {
            "app": theme_path + "assets\\sass\\index.scss"
        },

        output: {
            path: theme_path + "assets\\build\\wappsnet\\",
            filename: "style.min.js"
        },

        module: {
            rules:[{
                test: /\.(scss|sass)$/i,
                loader: ExtractTextPlugin.extract({
                    use: [
                        {
                            loader: 'css-loader',
                            options: {
                                sourceMap: true
                            }
                        },
                        {
                            loader: 'sass-loader',
                            options: {
                                sourceMap: true
                            }
                        }
                    ],
                    fallback: 'style-loader'
                })
            }]
        },

        plugins: [
            new ExtractTextPlugin("app.min.css", {
                allChunks: true
            }),

            new CleanWebpackPlugin(["app.min.js", "app.min.css"], {
                root: theme_path + "assets\\build\\wappsnet",
                verbose: true,
                dry: false
            }),

            new WebpackOnBuildPlugin(function(stats) {
                let file = theme_path + "assets\\build\\wappsnet\\style.min.js";
                fs.unlink(file, function() {
                    console.log(`file: status has been removed.`)
                });
            })
        ],

        optimization: {
            minimizer: [new UglifyJsPlugin()]
        }
    }
];