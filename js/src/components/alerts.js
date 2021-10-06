'use strict';

$ = jQuery;

var feature = require('./features');

if ( feature.alertWidget() ) {
  var cookie = 'su-homesite-show-alert';

  $('.widget_alert button').click(function (ev) {
    $(this).closest('.widget_alert').attr('aria-hidden', 'true');
    $('body').removeClass('alert');
    document.cookie = cookie + "=false;path=/";
  });

  var pattern   = '(?:(?:^|.*;\\s*)' + cookie + '\\s*\\=\\s*([^;]*).*$)|^.*$'
    , re        = new RegExp(pattern)
    , showAlert = document.cookie.replace(re, "$1")
    ;
  if (showAlert == 'false') {
    $('.widget_alert').attr('aria-hidden', 'true');
    $('body').removeClass('alert');
  } else {
    $('body').addClass('alert');
  }
}
