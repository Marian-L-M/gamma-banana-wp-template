const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');

module.exports = {
  ...defaultConfig,
  entry: {
    'themes/gamma-banana/build/index.js': './themes/gamma-banana/src/index.js',
  },
  output: {
    path: path.resolve(__dirname),
    filename: '[name].js',
  },
};