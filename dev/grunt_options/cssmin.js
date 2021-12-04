/**
 *
 * Module: grunt-contrib-cssmin
 * Documentation: https://github.com/gruntjs/grunt-contrib-cssmin
 *
 */

module.exports = {

  themecss: {
    options: {
      sourceMap: true
    },
    files: {
      '<%= pkg._themepath %>/css/master.min.css' : ['<%= pkg._themepath %>/css/master.css'],
      '<%= pkg._themepath %>/css/admin.min.css' : ['<%= pkg._themepath %>/css/admin.css']
    }
  }

  // printcss: {
  //   files  : {
  //     '<%= pkg._themepath %>/css/dist/print.min.css' : ['<%= pkg._themepath %>/css/print.css']
  //   }
  // },

  // themeeditor: {
  //   files: {
  //     '<%= pkg._themepath %>/css/admin/dist/editor-style.min.css' : ['<%= pkg._themepath %>/css/admin/editor-style.css']
  //   }
  // },

  // themelogin: {
  //   files: {
  //     '<%= pkg._themepath %>/css/admin/dist/login.min.css' : ['<%= pkg._themepath %>/css/admin/login.css']
  //   }
  // }

};