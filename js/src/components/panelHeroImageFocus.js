jQuery(".panel[data-type='hero-image'] figure").each(function() {
  jQuery(this).on('mouseover', function() {
    jQuery(this).closest('figure').attr('data-hover', 'true');
  });
  jQuery(this).on('mouseout', function() {
    jQuery(this).closest('figure').removeAttr('data-hover').removeAttr('data-focus');
  });
  jQuery(this).on('focusin', function() {
    jQuery(this).closest('figure').attr('data-focus', 'true');
  });
  jQuery(this).on('aria-selected', function() {
    jQuery(this).closest('figure').attr('data-focus', 'true');
  });
  jQuery(this).on('focusout', function() {
    jQuery(this).closest('figure').removeAttr('data-focus').removeAttr('data-hover');
  });

});