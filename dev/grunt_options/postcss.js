/**
 *
 * Module: grunt-postcss
 * Documentation: hhttps://www.npmjs.com/package/grunt-postcss
 *
 */

module.exports = {
  theme: {
    options: {
      map: true,

      processors: [
        require('autoprefixer')(),
        require('cssnano')()
      ]
    },
    files: {
      '<%= pkg._themepath %>/css/master.min.css': '<%= pkg._themepath %>/css/master.css',
      '<%= pkg._themepath %>/css/admin.min.css': '<%= pkg._themepath %>/css/admin.css',
    }
  }
};