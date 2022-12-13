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
        	'<%= pkg._themepath %>/dev/decanter/node_modules/bourbon/core' // This is in Decanter's node_modules
        , '<%= pkg._npmpath %>/bourbon-neat/core'
        , '<%= pkg._themepath %>/dev/decanter/core'
        , '<%= pkg._npmpath %>/neat-omega/core'
        , '<%= pkg._npmpath %>/normalize.css'
        , '<%= pkg._themepath %>/dev/decanter/node_modules/font-awesome/scss' // This is in Decanter's node_modules
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
