/**
 *
 * Module: grunt-git
 * Documentation: https://www.npmjs.org/package/grunt-git
 *
 *
 */

module.exports = {

	options: {
		token: '<%= pkg._slack_api_token %>',
		channel: '<%= pkg._slack_notification_channel %>',
		username: 'Deployment Bot',
		verbose:true
	},

	"wpe-stag": {
		options: {
			text: 'Deployment of HOMESITE to WP Engine staging complete at <%= grunt.template.today("isoDateTime") %>'
		}
	},

	"wpe-prod": {
		options: {
			text: 'Deployment of HOMESITE to WP Engine *PRODUCTION* complete at <%= grunt.template.today("isoDateTime") %>'
		}
	}
};