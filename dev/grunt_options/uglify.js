/**
 *
 * Module: grunt-contrib-uglify
 * Documentation: https://npmjs.org/package/grunt-contrib-uglify
 *
 */
module.exports = {

	thememin: {
		options: {
			banner: '/* Homesite: JS Master - <%= grunt.template.today("mm-dd-yyyy") %> */\n',
			sourceMap: false,
			compress: {
				drop_console: true
			}
		},
		files: {
			'<%= pkg._themepath %>/js/dist/master.min.js' : [
				'<%= pkg._themepath %>/js/libs.js',
				'<%= pkg._themepath %>/js/scripts.js'
			],
      '<%= pkg._themepath %>/js/dist/admin.min.js' : '<%= pkg._themepath %>/js/admin.js'
		}
	},
  themedev: {
    options: {
      banner: '/* Homesite: JS Dev Master - <%= grunt.template.today("mm-dd-yyyy") %> */\n',
      sourceMap: true,
      compress: {
        drop_console: false
      }
    },
    files: {
      '<%= pkg._themepath %>/js/dist/master.min.js' : [
        '<%= pkg._themepath %>/js/libs.js',
        '<%= pkg._themepath %>/js/scripts.js'
      ],
      '<%= pkg._themepath %>/js/dist/admin.min.js' : '<%= pkg._themepath %>/js/admin.js'
    }
  }
};