const path = require('path')

module.exports = {
    entry: './resources/js/index.js',
    output: {
        path: path.resolve(__dirname, 'public/assets/js'),
        filename: 'app.js'
    },
    mode: 'development',
    watch: true,
    module: {
        rules: [{
            test: /\.m?js$/,
            exclude: /(node_modules|bower_components)/,
            use: {
                loader: 'babel-loader',
            }
        }]
    }
}