'use strict';

jQuery(".highlight .highlight-link, .highlight .img-wrapper").each(function() {
  jQuery(this).on('mouseover focusin', function() {
    jQuery(this).closest('.highlight').attr('data-hover', 'true');
  });
  jQuery(this).on('mouseout focusout', function() {
    jQuery(this).closest('.highlight').removeAttr('data-hover');
  });
});