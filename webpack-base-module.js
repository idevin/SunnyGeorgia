const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');

// try to create universal file for all modules, not working yet
module.exports = (name) => ({
    entry: {
        excursion: path.resolve(__dirname, `resources/assets/${name}/js/${name}.js`),
    },

    output: {
        filename: `js/${name}/[name].[hash].js`,
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
                    name: `${name}-vendors`,
                    priority: 10,
                    enforce: true
                }
            }
        }
    },

    plugins: [
        new MiniCssExtractPlugin({
            publicPath: path.resolve(__dirname, 'public'),
            filename: `css/${name}/[name].[hash].css`,
        }),
        new BundleAnalyzerPlugin({
            analyzerMode: 'static',
            reportFilename: `./reports/${name}-report.html`,
            openAnalyzer: false
        }),
        new CleanWebpackPlugin([
            `public/reports/${name}-report.html`,
            `public/css/${name}/*`,
            `public/js/${name}/*`
        ], {}),
    ]
})
