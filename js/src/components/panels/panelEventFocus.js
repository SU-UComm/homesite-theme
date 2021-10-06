'use strict';
var $ = jQuery;

$(".panel[data-type='events'] figure .content h3 a, .panel[data-type='events'] figure  > .img-wrapper").each(function() {
  $(this).on('mouseover focusin', function() {
    $(this).closest('figure').attr('data-hover', 'true');
  });
  $(this).on('mouseout focusout', function() {
    $(this).closest('figure').removeAttr('data-hover');
  });
});