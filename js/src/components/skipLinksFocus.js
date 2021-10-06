'use strict';
var $ = jQuery;

var waypoints             = require('waypoints/lib/jquery.waypoints.js')
    , mobileMenuState       = require('./isMobileMenu')
    , isMobileMenu          = mobileMenuState()
    , isHeaderSplashPanel   = require('./isHeaderSplashPanel')
    , hasSplashPanel        = isHeaderSplashPanel()
    , retrieveSplashPanel   = require('./retrieveSplashPanel')
    , splashPanel           = retrieveSplashPanel()
    , areWeHome             = require('./isHome')
    , isHome                = areWeHome()

    // Initialize jQuery Objects

    , header                = $('body > header')
    , main                  = $('#main')
    , mainContent            = $('#main-content')
    , footer                = $('body > footer')
    , positioningStatement  = $('body > header [data-type="position-stmt"]')
    , brandBar              = $('#brand-bar')
    , siteNav               = $('#site-navigation')

    // Retrieve element measurements

    , splashPanelHeight     = $(splashPanel).outerHeight()
    , stmntHeight           = $(positioningStatement).outerHeight()
    , brandBarHeight        = $(brandBar).outerHeight()
    , navHeight             = $(siteNav).outerHeight()
;

// add a click handler to all links
// that point to same-page targets (href="#...")
$("a[href^='#']").click(function(e) {
  // capture the target selector
  var $target = $("#"+$(this).attr("href").slice(1)+"").selector;
  if ( isHome === true && hasSplashPanel === true ) {
    // Specifically check if the main element is being targeted
    if($($target).is(mainContent)) {
      if (positioningStatement.length !== 0) {
        $('html body').animate({
          scrollTop: $($target).offset().top + splashPanelHeight - navHeight - brandBarHeight - stmntHeight
        }, 400);
      } else {
        $('html body').animate({
          scrollTop: $($target).offset().top + splashPanelHeight - navHeight - brandBarHeight
        }, 400);
      }
    }
    $($target).focus();
  } else {
    if($($target).is(mainContent)) {
      $('html body').animate({
        scrollTop: $($target).offset().top - navHeight + 6
      }, 400);
    }
    $($target).focus();
  }
});
