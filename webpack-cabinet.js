const baseConfig = require('./webpack-base');
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const merge = require('webpack-merge');

module.exports = merge(baseConfig, {
    entry: {
        cabinet: path.resolve(__dirname, 'resources/assets/cabinet/js/cabinet.js'),
    },

    output: {
        filename: 'js/cabinet/[name].[hash].js',
        path: path.resolve(__dirname, 'public')
    },

    optimization: {
        splitChunks: {
            cacheGroups: {
                commons: {
                    test: /[\\/]node_modules[\\/]/,
                    name: 'cabinet-vendors',
                    // filename: 'js/[name].[hash].js',
                    chunks: 'all'
                }
            }
        }
    },

    plugins: [
        new MiniCssExtractPlugin({
            publicPath: path.resolve(__dirname, 'public'),
            filename: 'css/cabinet/[name].[hash].css',
        }),
        new CleanWebpackPlugin([
            'public/css/cabinet*',
            'public/js/cabinet/*'
        ], {}),
    ]
});
