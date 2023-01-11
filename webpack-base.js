const path = require('path'),
    env = require('./.env.webpack'),
    webpack = require('webpack'),
    SourceMapDevToolPlugin = require('webpack/lib/SourceMapDevToolPlugin'),
    MiniCssExtractPlugin = require('mini-css-extract-plugin'),
    OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin'),
    TerserPlugin = require('terser-webpack-plugin'),
    WebpackAssetsManifest = require('webpack-assets-manifest'),
    WebpackRequireFrom = require("webpack-require-from"),
    {VueLoaderPlugin} = require('vue-loader');

const CopyWebpackPlugin = require('copy-webpack-plugin');

function copyPatterns() {
    let path = ''
    switch (env['APP_ENV']) {
        case 'development':
            path = '../blog_dev/'
            break
        case 'production':
            path = '../blog'
            break
    }

    let paths = []

    if (path !== '') {
        paths = [
            {from: path + '/public/js/*', to: 'public/js/'},
            {from: path + '/public/images/*', to: 'public/images/'},
            {from: path + '/public/css/*', to: 'public/css/'},
            {from: path + '/public/fonts/*', to: 'public/fonts/'}
        ]
    }
    console.log('Copy Assets: ', paths)
    return paths;
}

module.exports = {
    mode: env['APP_ENV'],
    optimization: {
        minimize: env['APP_ENV'] === 'production',
        minimizer: [
            new TerserPlugin({
                terserOptions: {
                    ecma: 6,
                    compress: true,
                    output: {
                        comments: false,
                        beautify: false
                    }
                }
            }),
            new OptimizeCSSAssetsPlugin({
                cssProcessorPluginOptions: {
                    preset: ['default', {discardComments: {removeAll: true}}],
                }
            })
        ],
        usedExports: true,
        sideEffects: false
    },

    devtool: 'source-map',

    resolve: {
        extensions: ['.js', '.vue', '.html'],
        alias: {
            'vue$': 'vue/dist/vue.esm.js',
        }
    },

    module: {
        rules: [
            {
                // Matches all PHP or JSON files in `resources/lang` directory.
                test: /resources[\\\/]lang.+\.(php|json)$/,
                loader: 'laravel-localization-loader',
            },
            {
                test: /\.js$/,
                loader: 'babel-loader',
                options: {
                    babelrc: true,
                    compact: env['APP_ENV'] === 'production'
                }
            },
            {
                test: /\.html$/,
                loader: 'raw-loader',
            },
            {
                test: /\.css$/,
                use: [MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: {
                            url: false,
                            minimize: true,
                            sourceMap: true
                        }
                    }
                ]
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader',
            },
            {
                test: /\.scss$/,
                use: [MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: {
                            minimize: true,
                            sourceMap: true,
                            importLoaders: 2
                        }
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            outputStyle: 'expanded',
                            sourceMap: true,
                            sourceMapContents: true
                        }
                    },
                    {
                        loader: 'sass-resources-loader',
                        options: {
                            resources: [
                                './resources/assets/common-styles/variables.scss',
                                './resources/assets/common-styles/transitions.scss'
                            ]
                        }
                    }
                ]
            },
            {
                test: /\.(jpg|png|gif)$/,
                loader: 'file-loader?name=images/[name].[ext]'
            },
            {
                test: /\.svg$/,
                use: {
                    loader: 'svg-url-loader',
                    options: {}
                }
            },
            {
                test: /\.(woff2|woff)(\?v=\d+\.\d+\.\d+)?$/,
                use: {
                    loader: "url-loader",
                    options: {
                        // Limit at 50k. Above that it emits separate files
                        limit: 100000,

                        // url-loader sets mimetype if it's passed.
                        // Without this it derives it from the file extension
                        mimetype: "application/font-woff",

                        // Output below fonts directory
                        name: "fonts/[name].[ext]",
                    }
                },
            }
        ],
    },

    plugins: [
        new webpack.ContextReplacementPlugin(
            /moment[/\\]locale$/,
            /ru|en-gb|ka/
        ),

        new VueLoaderPlugin(),

        new WebpackAssetsManifest({
            merge: true
        }),

        new SourceMapDevToolPlugin({
            filename: null,
            test: /\.(js)($|\?)/i
        }),

        new WebpackRequireFrom({
            path: "/"
        }),

        new CopyWebpackPlugin(copyPatterns(), {force: true})
    ]
};
