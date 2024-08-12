const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const { VueLoaderPlugin } = require('vue-loader');
//Just to help us with directories and folders path

const __src = path.resolve(__dirname, 'src');

module.exports = {
    //Entry: main file that init our application
    entry: path.resolve(__src, 'index.js'),
    watch: true,

    //Output: result of the bundle after webpack run
    output: {
        filename: 'pushwork-dashboard.js',
        path: path.resolve(__dirname, 'dist'),
        clean: true
    },
    module: {
        rules: [
            //Vue loader. Says to webpack that files with .vue extension need to be processed by the vue-loader plugin
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            }
        ]
    },

    //Plugins to help and include additionals functionalities to webpack
    plugins: [
        new VueLoaderPlugin()
    ]
}