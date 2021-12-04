/**
 *
 * Module: grunt-contrib-watch
 * Documentation: https://npmjs.org/package/grunt-contrib-watch
 *
 */

module.exports = {

	themecss: {
		files: [
      '<%= pkg._themepath %>/scss/*.scss',
      '<%= pkg._themepath %>/scss/**/*.scss'
		],
		tasks: [
      'sass:theme',
      'postcss:theme',
      'clean:theme'
		],
		options: {
			spawn: false,
			livereload: true
		}
	},

	themescripts   : {
		files  : [
			'<%= pkg._themepath %>/js/*.js',
			'<%= pkg._themepath %>/js/**/*.js',
		],
		tasks  : [
		  'clean:thememinjs',
      'copy:theme',
      'concat:libs',
			'webpack:themedev',
      'uglify:themedev'
		],
		options: {
			spawn     : false,
			livereload: true
		}
	},

  fonts   : {
    files  : [
      '<%= pkg._npmpath %>/font-awesome/fonts/**',
      'dev/fonts-build/fonts/**'
    ],
    tasks  : [
      'clean: fonts',
      'copy: fonts'
    ],
    options: {
      spawn     : false,
      livereload: true
    }
  },

	themetemplates : {
		files  : [
      '<%= pkg._themepath %>/*.php',
			'<%= pkg._themepath %>/**/*.php'
		],
		options: {
			spawn     : false,
			livereload: true
		}
	}

};
