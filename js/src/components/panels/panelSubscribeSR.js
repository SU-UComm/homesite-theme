'use strict';
var $ = jQuery;

$('.panel[data-type="subscribe-sr"] input[type="email"]').each(function() {
  var $this = $(this);

  $this.on('focusin', function() {
    $this.closest('form').attr('data-focus', 'true');
  });
  $this.on('focusout', function() {
    $this.closest('form').removeAttr('data-focus');
  });
});