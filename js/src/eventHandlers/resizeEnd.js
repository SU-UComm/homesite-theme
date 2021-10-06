'use strict';
var $ = jQuery;
;

// Call responsive funtion when browser window resizing is complete
$(window).on('resizeEnd', function() {
  // ---------------------------------------------------------
  // Initialize local variables & functions
  // ---------------------------------------------------------
  var feature           = require('../components/features')
    , object            = require('../components/objects')
    , isMobileMenu      = feature.mobileMenu()
    , currentBreakpoint = feature.breakpointDetect()

  // Initialize jQuery Objects

    , brandBar          = $('#brand-bar')
    , $siteNav          = $('#site-navigation')
    , $gatewayNav       = $('#gateway')
    , $headerBrand      = $('#header--wordmark')
    , $searchToggle     = $('#search-toggle')
  ;

  Waypoint.disableAll();
  Waypoint.enableAll();

  // ---------------------------------------------------------
  // Put the Nav Menu in it's correct parent container for
  // the current context
  // ---------------------------------------------------------
  if ( $gatewayNav.length ) {
    if ( isMobileMenu ) {
      // Move gateway nav under site nav on small devices
      if ( $( '#' + $siteNav[ 0 ].id + '> #' + $gatewayNav[ 0 ].id ).length === 0 ) {
        $gatewayNav.attr( 'style', 'display: none;' ).detach().appendTo( $siteNav ).removeAttr( 'style' );
      }
    } else {
      // Move gateway nav to brand bar on small devices
      if ( $( '#' + brandBar[ 0 ].id + ' > #' + $gatewayNav[ 0 ].id ).length === 0 ) {
        $gatewayNav.attr( 'style', 'display: none;' ).detach().insertBefore( $searchToggle ).removeAttr( 'style' );
      }
    }
  }

  // ---------------------------------------------------------
  // Shorten the brand mark on small screens
  // ---------------------------------------------------------
  $headerBrand.text( (currentBreakpoint == 'xs') ? 'Stanford' : 'Stanford University' );

  // note: these run asyncrhonously
  $(this).trigger('panelImageContentAdjust');
  $(this).trigger('navKeyboardBindings');
});

// note resize events and trigger resizeEnd event when resizing stops
$(window).resize(function() {
  if ( this.resizeTO ) clearTimeout( this.resizeTO ); // if we already have a timeout set, clear it
  this.resizeTO = setTimeout(function() {
    $(this).trigger( 'resizeEnd' );
  }, 125); // wait 125 msec before declaring that resize has ended
});