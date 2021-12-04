/**
 *
 * Module: grunt-header
 * Documentation: https://github.com/sindresorhus/grunt-header
 *
 */

module.exports = {

	themecss: {
		options: {
			text: '/* Stanford Homesite 2017: Global CSS - <%= grunt.template.today("mm-dd-yyyy") %> */'
		},
		files  : {
			'<%= pkg._themepath %>/css/dist/master.min.css' : ['<%= pkg._themepath %>/css/dist/master.min.css'],
      '<%= pkg._themepath %>/css/dist/master.min.css.map' : ['<%= pkg._themepath %>/css/dist/master.min.css.map']
		}
	}

	// printcss: {
	// 	options: {
	// 		text: '/* Stanford Homesite 2017: Print CSS - <%= grunt.template.today("mm-dd-yyyy") %> */'
	// 	},
	// 	files  : {
	// 		'<%= pkg._themepath %>/css/dist/print.min.css' : ['<%= pkg._themepath %>/css/dist/print.min.css']
	// 	}
	// },

	// themeeditor: {
	// 	options: {
	// 		text: '/* Stanford Homesite 2017: Visual Editor CSS - <%= grunt.template.today("mm-dd-yyyy") %> */'
	// 	},
	// 	files  : {
	// 		'<%= pkg._themepath %>/css/admin/dist/editor-style.min.css' : ['<%= pkg._themepath %>/css/admin/dist/editor-style.min.css']
	// 	}
	// },

	// themelogin: {
	// 	options: {
	// 		text: '/* Stanford Homesite 2017: WordPress Login CSS - <%= grunt.template.today("mm-dd-yyyy") %> */'
	// 	},
	// 	files  : {
	// 		'<%= pkg._themepath %>/css/admin/dist/login.min.css' : ['<%= pkg._themepath %>/css/admin/dist/login.min.css']
	// 	}
	// }

};