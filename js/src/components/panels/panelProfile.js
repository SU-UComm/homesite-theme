'use strict';

// ---------------------------------------------------------
// Initialize local variables & functions
// ---------------------------------------------------------

var $ = jQuery
  , waypoints             = require('waypoints/lib/jquery.waypoints.js')
  , feature               = require('../features')
  , isMobileMenu          = feature.mobileMenu()

  // Initialize jQuery Objects

  , header                = $('body > header')
  , main                  = $('#main')
  , footer                = $('body > footer')
  , brandBar              = $('#brand-bar')
  , siteNav               = $('#site-navigation')
  , profilePanel          = $('[data-type="profile"]')

  // Retrieve element measurements

  , brandBarHeight        = $(brandBar).outerHeight()
  , navHeight             = $(siteNav).outerHeight()
;

// Profile Panel Waypoints
// Shortcuts to useful element waypoints:
$(profilePanel).each(function () {
  var $this = $(this)
    , revealPosition = null
  ;

  $this.attr('data-hide-content', 'true');
  // console.log('hideContent');

  // ---------------------------------------------------------------------------
  // Sweet Spot - Scroll Events
  // ---------------------------------------------------------------------------
  $this.waypoint(function (direction) {
    if (direction === 'down') {
      if ( revealPosition !== 'chrome' ) {
        console.log('Reveal Profile Panel Contents - Sweet Spot');
        $this.removeAttr('data-hide-content');
        revealPosition = 'sweetSpot';
      }
    } else {
      if (revealPosition === 'sweetSpot') {
        console.log('Hide Profile Panel Contents, scrolling up - Sweet Spot');
        $this.attr('data-hide-content', 'true');
      }
    }
  }, {
    offset: function () {
      if (isMobileMenu === true) {
        return ( ($(window).outerHeight() / 2) - ( -brandBarHeight + ($this.outerHeight() / 2) ) );
      } else {
        return ( ($(window).outerHeight() / 2) - ( -(navHeight + brandBarHeight + 50) + ($this.outerHeight() / 2) ) );
      }
    }
  });


  // Top edge of element reaches bottom of top chrome
  $(this).waypoint(function (direction) {
    if (direction === 'down') {
      if ( revealPosition !== 'sweetSpot' ) {
        console.log('Reveal Profile Panel Contents');
        $this.removeAttr('data-hide-content');
        revealPosition = 'chrome';
      }
    } else {
      if (revealPosition === 'chrome') {
        console.log('Hide Profile Panel Contents, scrolling up');
        $this.attr('data-hide-content', 'true');
      }
    }
  }, {
    offset: function () {
      if (isMobileMenu === true) {
        return ( brandBarHeight );
      } else {
        return ( navHeight + brandBarHeight );
      }
    }
  });

});