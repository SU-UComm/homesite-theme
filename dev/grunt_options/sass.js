/**
 *
 * Module: grunt-sass
 * Documentation: https://github.com/sindresorhus/grunt-sass
 * Example:
 *
 */

module.exports = {

	theme: {
		mode: 'native',
		options: {
			includePaths: [
        	'<%= pkg._npmpath %>/bourbon/core'
        , '<%= pkg._npmpath %>/bourbon-neat/core'
        , '<%= pkg._npmpath %>/decanter/core'
        , '<%= pkg._npmpath %>/neat-omega/core'
        , '<%= pkg._npmpath %>/normalize.css'
        , '<%= pkg._npmpath %>/font-awesome/scss'
			],
      precision: 10,
			outputStyle: 'nested',
			sourceMap  : true
		},
		files  : {
      '<%= pkg._themepath %>/css/master.css' : '<%= pkg._themepath %>/scss/master.scss',
      '<%= pkg._themepath %>/css/admin.css' : '<%= pkg._themepath %>/scss/admin.scss'
		}
	}

};
