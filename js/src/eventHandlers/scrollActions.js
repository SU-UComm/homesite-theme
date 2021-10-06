'use strict';

// ---------------------------------------------------------
// Initialize local variables & functions
// ---------------------------------------------------------
var $                     = jQuery
  , waypoints             = require('waypoints/lib/jquery.waypoints.js')
  , feature               = require('../components/features')
  , hasSplashPanel        = feature.splashPanel()
  , isEmergencyPage       = feature.emergencyPage()

  // Initialize jQuery Objects
  , $main                 = $('#main')
  , $entryContent         = $('.entry-content')
  , $brandBar             = $('#brand-bar')
  , $siteNav              = $('#site-navigation')

  // Retrieve element measurements

  , brandBarHeight        = $brandBar.outerHeight()
  , siteNavHeight         = $siteNav.outerHeight()
;

// ---------------------------------------------------------
// Add shadow to nav
// ---------------------------------------------------------
if ( isEmergencyPage ) {
  $siteNav.addClass('theme--choco');
  $entryContent.waypoint(function (direction) {
    //console.log('In emergency page waypoint');
    if (direction === 'down') {
      $siteNav.addClass('shadow').removeClass('theme--choco');
    } else if (direction === 'up') {
      $siteNav.removeClass('shadow').addClass('theme--choco');
    }
  }, {
    offset: function () {
      return brandBarHeight + siteNavHeight;
    }
  });
} else if ( !hasSplashPanel ) {
  // ---------------------------------------------------------
  // Add shadow when there isn't a splash panel
  // (see ../components/panels/splashImage.js for when there is a splash panel)
  // ---------------------------------------------------------
  $main.waypoint(function (direction) {
    if (direction === 'down') {
      $siteNav.addClass('shadow');
    } else if (direction === 'up') {
      $siteNav.removeClass('shadow');
    }
  }, {
    offset: function () {
      return brandBarHeight;
    }
  });
}