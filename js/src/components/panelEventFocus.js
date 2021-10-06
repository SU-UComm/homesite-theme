'use strict';

jQuery(".panel[data-type='events'] figure .content h3 a, .panel[data-type='events'] figure  > .img-wrapper").each(function() {
  jQuery(this).on('mouseover focusin', function() {
    jQuery(this).closest('figure').attr('data-hover', 'true');
  });
  jQuery(this).on('mouseout focusout', function() {
    jQuery(this).closest('figure').removeAttr('data-hover');
  });
});