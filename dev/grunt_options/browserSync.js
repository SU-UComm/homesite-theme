/**
 *
 * Module: grunt-browser-sync
 *
 */

module.exports = {

	dev: {
		bsFiles: {
			src: [
        '<%= pkg._themepath %>/fonts/*.otf',
      	'<%= pkg._themepath %>/fonts/*.eot',
      	'<%= pkg._themepath %>/fonts/*.svg',
      	'<%= pkg._themepath %>/fonts/*.ttf',
      	'<%= pkg._themepath %>/fonts/*.woff',
      	'<%= pkg._themepath %>/fonts/*.woff2',
				'<%= pkg._themepath %>/css/*.css',
        '<%= pkg._themepath %>/css/*.map',
				'<%= pkg._themepath %>/**/*.php',
        '<%= pkg._themepath %>/js/*.js',
        '<%= pkg._themepath %>/js/**/*.js',
				'<%= pkg._themepath %>/img/**/*.jpg',
				'<%= pkg._themepath %>/img/**/*.png'
			]
		},
		options: {
			watchTask     : true,
			debugInfo     : true,
			logConnections: true,
			notify        : true,
			proxy         : '<%= dev.proxy %>',
			ghostMode     : {
				scroll: true,
				links : true,
				forms : true
			}
		}
	}

};