'use strict';
var $ = jQuery;

// Call responsive funtion when browser window resizing is complete
$(window).on('resizeEnd', function() {
  // ---------------------------------------------------------
  // Initialize local variables & functions
  // ---------------------------------------------------------
  var waypoints             = require('waypoints/lib/jquery.waypoints.js')
    , Mousetrap             = require('mousetrap')
    , mobileMenuState       = require('./isMobileMenu')
    , isMobileMenu          = mobileMenuState()
    , isHeaderSplashPanel   = require('./isHeaderSplashPanel')
    , hasSplashPanel        = isHeaderSplashPanel()
    , retrieveSplashPanel   = require('./retrieveSplashPanel')
    , splashPanel           = retrieveSplashPanel()
    , breakpoint            = require('./breakpoint')
    , currentBreakpoint     = breakpoint()
    , areWeHome             = require('./isHome')
    , isHome                = areWeHome()

  // Initialize jQuery Objects

    , header                = $('body > header')
    , main                  = $('#main')
    , footer                = $('body > footer')
    , menuToggle            = document.getElementById('menu-toggle')
    , positioningStatement  = $('body > header [data-type="position-stmt"]')
    , brandBar              = $('#brand-bar')
    , siteNav               = $('#site-navigation')
    , searchToggle          = $('#search-toggle')
    , searchWrapper         = $('#search-wrapper')
    , gatewayNav            = $('#gateway')
    , headerBrand           = $('#header--wordmark')

  // Retrieve element measurements

    , mainHeight            = $(main).outerHeight()
    , splashPanelHeight     = $(splashPanel).outerHeight()
    , stmntHeight           = $(positioningStatement).outerHeight()
    , brandBarHeight        = $(brandBar).outerHeight()
    , navHeight             = $(siteNav).outerHeight()
  ;

  // Destroy waypoints
  //Waypoint.destroyAll();

  // ---------------------------------------------------------
  // Put the Nav Menu in it's correct parent container for
  // the current context
  // ---------------------------------------------------------
  if (isMobileMenu === true) {
    // Move gateway nav under site nav on small devices
    if ( $( '#' + siteNav[0].id + '> #' + gatewayNav[0].id ).length === 0) {
      $( gatewayNav ).attr('style', 'display: none;').detach().appendTo( siteNav ).removeAttr( 'style' );
    }
  } else {
    // Move gateway nav to brand bar on small devices
    if ( $('#' + brandBar[0].id + ' > #' + gatewayNav[0].id).length === 0 ) {
      $( gatewayNav ).attr('style', 'display: none;').detach().prependTo( brandBar ).removeAttr( 'style' );
    }

    if ( hasSplashPanel ) {
      // When there is a splash panel, move site nav to splash panel
      if ( $(splashPanel).children('#' + siteNav[0].id).length === 0 ) {
        $( siteNav ).attr( 'style', 'display: none;' ).detach().appendTo($( splashPanel )).removeAttr( 'style' );
      }
      // Check if search wrapper is in the correct location
      if ( $( splashPanel).find( searchWrapper ).length === 0 ) {
        $(searchWrapper).detach().insertBefore( siteNav );
      }
    } else {
      $( siteNav ).addClass( 'fixed' );
    }
  }

  // ---------------------------------------------------------
  // Sticky Nav Choreography (when there is a splash panel)
  // ---------------------------------------------------------
  // Note that we calculate from the splash panel height, and
  // not from the nav element. This is to avoid weird recalculations
  // when the navigation becomes sticky
  if ( hasSplashPanel ) {
    $( splashPanel ).waypoint(function (direction) {
      if (direction === 'down') {
        $( siteNav ).addClass('fixed').addClass('shadow');
        // Check if search wrapper is in the correct location
        if ( $( 'header > #search-wrapper' ).length === 0 ) {
          $(searchWrapper).detach().appendTo( header );
        }
      } else if (direction === 'up') {
        $( siteNav ).removeClass('fixed').removeClass('shadow');
        // Check if search wrapper is in the correct location
        if ( $( splashPanel).find( searchWrapper ).length === 0 ) {
          $(searchWrapper).detach().insertBefore( siteNav );
        }
      }
    }, {
      offset: function () {
        var bottomSpacing = parseFloat($( siteNav ).css("font-size"));
        return -( $( splashPanel ).outerHeight() - $( siteNav ).outerHeight() - $( brandBar ).outerHeight() - bottomSpacing ) ;
      }
    });
    // ---------------------------------------------------------
    // Sticky Nav Choreography (when there isn't a splash panel)
    // ---------------------------------------------------------
  } else {
    $(main).waypoint(function (direction) {
      if (direction === 'down') {
        $(siteNav).addClass('shadow');
      } else if (direction === 'up') {
        $(siteNav).removeClass('shadow');
      }
    }, {
      offset: function () {
        return $(brandBar).outerHeight();
      }
    });
  }


  // ---------------------------------------------------------
  // Curtain Reveal Choreography
  // ---------------------------------------------------------

  // Waypoints

  if ( hasSplashPanel ) {

    $( header ).waypoint(function (direction) {
      if (direction === 'down') {
        $( main ).removeAttr( 'class' ).removeAttr( 'style' );
        $( footer ).removeAttr( 'style' );

      } else if (direction === 'up') {

        // todo: make this into a function: 'curtain Reveal Initial State'
        $( main ).addClass('fixed');
        var currentNavHeight = $(siteNav).outerHeight();

        if ( isMobileMenu === true ) {
          $(footer).css('margin-top', mainHeight + stmntHeight + brandBarHeight );
        } else {
          $(footer).css('margin-top', mainHeight + stmntHeight );
        }

        if ( $( positioningStatement ).length !== 0 ) {
          if ( isMobileMenu === true ) {
            $( main ).removeAttr( 'style' ).css( 'margin-top', stmntHeight + brandBarHeight );
          } else {
            var shadowAffordance = 5;
            $( main ).removeAttr( 'style' ).css( 'margin-top', stmntHeight + brandBarHeight + navHeight - shadowAffordance );
          }
        }
        // end todo;

      }
    }, {
      offset: function () {
        if ( isMobileMenu ) {
          return -(splashPanelHeight);
        } else {
          return -(splashPanelHeight - brandBarHeight);
        }
      }
    });
  }


  // ---------------------------------------------------------
  // Shorten the brand mark on small screens
  // ---------------------------------------------------------
  if ( breakpoint() !== 'xs') {
    $( '#' + brandBar[0].id + ' #' + headerBrand[0].id ).text("Stanford University");
  } else {
    $( '#' + brandBar[0].id + ' #' + headerBrand[0].id ).text("Stanford");
  }

  // ---------------------------------------------------------
  // Homepage Brand Curtain Reveal Choreography
  // ---------------------------------------------------------
  // Note that we calculate from the splash panel height, and
  // not from the brand element. This is to avoid weird recalculations
  // when the brand element becomes sticky
  if ( isHome === true && hasSplashPanel === true ) {
    $( splashPanel ).waypoint(function (direction) {
      if (direction === 'down') {
        // check if header brand is in the right location
        if ( $( '#' + brandBar[0].id +  ' #' + headerBrand[0].id ).length === 0) {
          $(headerBrand).removeClass('fade-in').addClass('fade-out');
          setTimeout(function () {
            if (breakpoint() !== 'xs') {
              var headerBrandText = "Stanford University";
            } else {
              var headerBrandText = "Stanford";
            }
            $(headerBrand).detach().html( headerBrandText ).prependTo(brandBar).removeAttr('style').removeClass('fade-out').addClass('fade-in');
          }, 300);
          setTimeout(function () {
            $(headerBrand).removeClass('fade-in');
          }, 600);
        }
      } else {
        // check if header brand is in the right location
        if ( $( splashPanel ).find( headerBrand ).length === 0) {
          $(headerBrand).removeClass('fade-in').addClass('fade-out');
          setTimeout(function () {
            $(headerBrand).attr('style', 'display: none;').detach().html('Stanford').prependTo(splashPanel);
            if ( $( searchToggle ).attr('aria-expanded') === 'false' ) {
              $(headerBrand).removeAttr('style').removeClass('fade-out').addClass('fade-in');
            }
          }, 300);
          setTimeout(function () {
            if ( $( searchToggle ).attr('aria-expanded') === 'false' ) {
              $(headerBrand).removeClass('fade-in');
            }
          }, 600);
        }
      }
    }, {
      offset: function () {
        // Since the brand mark size varies by breakpoint,
        // we want an approx value instead of calculating it every time.
        // This is especially important when we resize from small
        // to a large breakpoint.
        var brandMarkHeight = 120;
        return -( ($( splashPanel ).outerHeight() / 2) - brandMarkHeight ) ;
      }
    });
  }
});

// note resize events and trigger resizeEnd event when resizing stops
$(window).resize(function() {
  if(this.resizeTO) clearTimeout(this.resizeTO);
  this.resizeTO = setTimeout(function() {
    $(this).trigger('resizeEnd');
    $(this).trigger('panelImageContentAdjust');
    $(this).trigger('keyboardBindings');
    $(this).trigger('skipLinksFocus');
  }, 200);
});