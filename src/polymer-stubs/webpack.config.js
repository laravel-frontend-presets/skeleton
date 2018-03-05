'use strict';

const webpack = require('webpack');
const path = require('path');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const WorkboxPlugin = require('workbox-webpack-plugin');

module.exports = {
    entry: {
        my: './resources/assets/elements/my-app.html'
    },
    output: {
        filename: '[name].bundle.js',
        path: path.resolve(__dirname, './public/dist'),
        publicPath: 'dist/'
    },
    resolve: {
        modules: ['node_modules', 'bower_components'],
        descriptionFiles: ['package.json']
    },
    devtool: 'inline-source-map',
    module: {
        rules: [{
                test: /\.html$/,
                use: [{
                        loader: 'babel-loader',
                        options: {
                            presets: ['env'],
                            plugins: ['syntax-dynamic-import']
                        }
                    },
                    {
                        loader: 'polymer-webpack-loader'
                    }
                ]
            },
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                use: [{
                    loader: 'babel-loader',
                    options: {
                        presets: ['env']
                    }
                }]
            }
        ]
    },
    plugins: [
        //Ignore moment.js locales
        new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/),

        new CopyWebpackPlugin(
            [
                //Copy custom elements polyfill
                {
                    from: path.resolve(__dirname, 'bower_components/webcomponentsjs/*.js'),
                    ignore: [
                        'gulpfile.js'
                    ],
                    to: 'bower_components/webcomponentsjs/[name].[ext]'
                },
                //Copy service worker library
                {
                    from: require.resolve('workbox-sw'),
                    to: 'workbox-sw.prod.js'
                }
            ]
        ),

        //Service worker helper
        new WorkboxPlugin({
            globDirectory: './public/dist',
            globPatterns: ['**/*.{html,js,css}'],
            swSrc: './resources/assets/js/service-worker.js',
            swDest: './public/service-worker.js'
        })
    ],
    devServer: {
        proxy: {
            "/": "http://127.0.0.1:8000",
        }
    }
};
