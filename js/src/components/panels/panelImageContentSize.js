'use strict';
var $ = jQuery;

// Panel Adjustment function
$(window).on('panelImageContentAdjust', function() {
  $('[data-type="image-content"]').each(function() {
    var feature               = require('../features')
      , currentBreakpoint     = feature.breakpointDetect()
    ;

    if ( currentBreakpoint === 'xs' || currentBreakpoint === 'sm' ) {
      var padding = $(this).find('.content:last-child').css('padding-right')
        , unitlessPadding = parseInt(padding)
        , captionHeight = $(this).find('figcaption').outerHeight()
        , padding = ((unitlessPadding * 2) + captionHeight)
        , margin = -((unitlessPadding * 2) + captionHeight);
      $(this).find('.content:last-child').css('padding-top', padding).css('margin-top', margin);
    } else {
      $(this).find('.content:last-child').removeAttr('style');
    };
  });
});

$(window).trigger('panelImageContentAdjust');