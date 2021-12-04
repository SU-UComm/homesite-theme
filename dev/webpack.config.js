var path = require("path");
var webpack = require("webpack");
module.exports = {
  cache: true,
  entry  : {
    scripts: './<%= pkg._themepath %>/js/src/index.js',
    admin:   './<%= pkg._themepath %>/js/src/admin.js'
  },
  output : {
    filename: '[name].js',
    path    : path.resolve(__dirname + '/../<%= pkg._themepath %>/js')
  },
  externals: {
    "jquery": "jQuery"
  },
  resolve: {
    extensions: ['.js', '.jsx'],
    modules: [
      "<%= pkg._npmpath %>"
    ]
  },
  module: {
    rules: [
      {
        test   : /\.js$/,
        exclude: /node_modules/
      }
    ]
  }
};