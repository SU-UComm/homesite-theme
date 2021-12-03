/**
 *
 * Module: grunt-contrib-clean
 * Documentation: https://npmjs.org/package/grunt-contrib-clean
 *
 */

module.exports = {

	theme: [
		'<%= pkg._themepath %>/css/*-temp*'
	],

	thememincss: [
		'<%= pkg._themepath %>/css/dist/*.css*',
		'<%= pkg._themepath %>/css/admin/dist/*.css*'
	],

	thememinjs: [
		'<%= pkg._themepath %>/js/dist/*.js'
	],

	fonts: [
    '<%= pkg._themepath %>/fonts/fontawesome*',
    '<%= pkg._themepath %>/fonts/Stanford*'
	],

	deploy: {
		src: [
			'<%= pkg._deploypath %>/*',
			'!<%= pkg._deploypath %>/.git'
		]
	}
};