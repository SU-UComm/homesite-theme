'use strict';
var $ = jQuery
  , menuToggle   = $('#menu-toggle')
  , $blurTargets = $('#main, footer, .panel[data-type="splash-image"] img, #splash--wordmark, #splash--scroller')
;

$( '#menu-toggle, #menu-overlay' ).click(function() {
  var targets = $('#menu-toggle, .menu-primary-nav-container, #gateway, #menu-overlay');
  if ( menuToggle.attr( 'aria-expanded' ) === 'true' ) {
    $( targets ).attr( 'aria-expanded', 'false' );
    $(menuToggle).html( 'Menu' );
    $blurTargets.removeClass( 'blur' );
  } else {
    var searchToggle = $('#search-toggle');
    if ( $(searchToggle).attr( 'aria-expanded' ) === 'true' ) {
      searchToggle.click();
    }
    $( targets ).attr( 'aria-expanded', 'true' );
    $(menuToggle).html( 'Close' );
    $blurTargets.addClass( 'blur' );
  }
});