/**
 *
 * Module: gruntphpsetconstant
 * Documentation: https://www.npmjs.org/package/grunt-php-set-constant
 *
 */

module.exports = {

	config: {
		constant: 'BUILD_THEME_ASSETS_TIMESTAMP',
		value   : '<%= grunt.template.today("yyyy.mm.dd.hh.MM") %>',
		file    : 'build-process.php'
	}

};