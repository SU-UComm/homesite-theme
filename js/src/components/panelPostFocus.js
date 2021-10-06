'use strict';

jQuery(".panel[data-type='posts'] article h3 a, .panel[data-type='posts'] article  .img-wrapper").each(function() {
  jQuery(this).on('mouseover focusin', function() {
    jQuery(this).closest('article').attr('data-hover', 'true');
  });
  jQuery(this).on('mouseout focusout', function() {
    jQuery(this).closest('article').removeAttr('data-hover');
  });
});