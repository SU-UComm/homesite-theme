'use strict';
var $ = jQuery;

$(".panel[data-type='hero-image'] figure").each(function() {
  $(this).on('mouseover', function() {
    $(this).closest('figure').attr('data-hover', 'true');
  });
  $(this).on('mouseout', function() {
    $(this).closest('figure').removeAttr('data-hover').removeAttr('data-focus');
  });
  $(this).on('focusin', function() {
    $(this).closest('figure').attr('data-focus', 'true');
  });
  $(this).on('aria-selected', function() {
    $(this).closest('figure').attr('data-focus', 'true');
  });
  $(this).on('focusout', function() {
    $(this).closest('figure').removeAttr('data-focus').removeAttr('data-hover');
  });

});