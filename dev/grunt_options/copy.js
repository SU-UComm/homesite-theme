/**
 *
 * Module: grunt-contrib-copy
 * Documentation: https://npmjs.org/package/grunt-contrib-copy
 * Example:
 *
 main: {
  files: [
    // includes files within path
    {expand: true, src: ['path/*'], dest: 'dest/', filter: 'isFile'},

    // includes files within path and its sub-directories
    {expand: true, src: ['path/**'], dest: 'dest/'},

    // makes all src relative to cwd
    {expand: true, cwd: 'path/', src: ['**'], dest: 'dest/'},

    // flattens results to a single level
    {expand: true, flatten: true, src: ['path/**'], dest: 'dest/', filter: 'isFile'}
  ]
  }
 *
 */

module.exports = {
  theme: {
    files: [
      {
        expand : true,
        flatten: true,
        src    : [
          '<%= pkg._npmpath %>/jquery/dist/jquery.js',
          '<%= pkg._npmpath %>/jquery/dist/jquery.min.js',
          '<%= pkg._npmpath %>/jquery/dist/jquery.min.map'
        ],
        dest   : '<%= pkg._themepath %>/js/'
      }
    ]
  },
  postcss: {
    files: [
      {
        expand  : true,
        flatten : true,
        src     : [
          '<%= pkg._themepath %>/css/master.css',
          '<%= pkg._themepath %>/css/master.css.map',
          '<%= pkg._themepath %>/css/master.min.css',
          '<%= pkg._themepath %>/css/master.min.css.map',
          '<%= pkg._themepath %>/css/admin.css',
          '<%= pkg._themepath %>/css/admin.css.map',
          '<%= pkg._themepath %>/css/admin.min.css',
          '<%= pkg._themepath %>/css/admin.min.css.map'
        ],
        dest    : '<%= pkg._themepath %>/css/dist/'
      }
    ]
  },
  fonts: {
    files: [
      {
        expand : true,
        flatten: true,
        filter: 'isFile',
        src    : [
          '<%= pkg._npmpath %>/font-awesome/fonts/**',
          'dev/fonts-build/fonts/**'
        ],
        dest   : '<%= pkg._themepath %>/fonts/'
      }
    ]
  }
};
