const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const baseConfig = require('./webpack-base');
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const merge = require('webpack-merge');

module.exports = merge(baseConfig, {
    entry: {
        excursion: [
            'core-js/modules/es.promise',
            'core-js/modules/es.array.iterator',
            path.resolve(__dirname, 'resources/assets/excursion/js/excursion.js')
        ],
    },

    output: {
        filename: 'js/excursion/[name].[hash].js',
        path: path.resolve(__dirname, 'public')
    },

    optimization: {
        splitChunks: {
            chunks: 'async',
            name: true,
            cacheGroups: {
                commons: {
                    chunks: "initial",
                    minChunks: 2,
                    maxInitialRequests: 5, // The default limit is too small to showcase the effect
                    minSize: 0 // This is example is too small to create commons chunks
                },
                vendor: {
                    test: /node_modules/,
                    chunks: "initial",
                    name: "excursion-vendors",
                    priority: 10,
                    enforce: true
                }
            }
        }
    },

    plugins: [
        new MiniCssExtractPlugin({
            publicPath: path.resolve(__dirname, 'public'),
            filename: 'css/excursion/[name].[hash].css',
        }),
        new BundleAnalyzerPlugin({
            analyzerMode: 'static',
            reportFilename: './reports/excursion-report.html',
            openAnalyzer: false
        }),
        new CleanWebpackPlugin([
            'public/reports/excursion-report.html',
            'public/css/excursion/*',
            'public/js/excursion/*'
        ], {}),
    ]
});
