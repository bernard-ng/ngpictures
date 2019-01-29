const path = require('path')

module.exports = {
    entry: './resources/js/index.js',
    output: {
        path: path.resolve(__dirname, 'public/assets/js'),
        file: 'app.js'
    }
}