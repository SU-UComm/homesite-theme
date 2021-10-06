'use strict';
var $ = jQuery;

// Declare variables to be shared by all the code in this file.
// Variables will be initialized in $(document).ready(function(){}),
// after all the relevant elements are present in the DOM.
var feature = require('../features')
  , objects = require('../objects')
  , $header
  , $main
  , $footer
  , $brandBar
  , $siteNav
  , $searchWrapper
  , $searchToggle
  , $menuToggle
  , $splashPanel
  , splashPanelTheme
  , splashPanelScrollType
  , $splashScroller
  , contentLocation // 'below' CTA, 'within' splashPanel, 'above' nav
  , prevWindowHeight
  , prevWindowWidth
  , $mainShadow // dynamically created element that maintains spacing when $main becomes fixed
;

// ---------------------------------------------------------
// Local functions
// ---------------------------------------------------------

// Set inital state on page load
function splashPanelInit() {
  // set the initial height of the splash panel
  setSplashPanelHeight();

  // tell the nav and the search wrapper that we have a splash screen
  $siteNav.addClass( splashPanelTheme ); // give the nav the same theme as the splash panel
  $searchWrapper.addClass( 'splash' ); // tell the search wrapper we're splashy

  // if there's a video in splash panel
  if ($('#splash-video')[0]) {
    playVideo();
    $searchToggle.click( pauseVideo ); // if search button is clicked, pause the video
    $menuToggle.click( pauseVideo ); // if mobile menu button is clicked, pause the video
  }

  $('#splash-video').click(toggleVideo);
  $('#splash--pause').click(toggleVideo);
  $('#splash-video').on('ended', changeButtonToPlay);

  switch ( splashPanelScrollType ) {
    case 'parallax':
      contentLocation = 'below'; // assume we start at the top of the page and the main content is below the CTA
      $brandBar.addClass ( splashPanelTheme ); // give the brand bar the same theme as the splash panel
      initParallaxWaypoints(); // set up appropriate waypoints
      // respond to opening and closing the search form - these events are triggered in searchBehavior.js
      $searchToggle.on( 'open', function () {
        makeNavSplashy( contentLocation === 'below' );
      } );
      $searchToggle.on( 'close', function () {
        makeNavSplashy( contentLocation !== 'above' );
      } );
      break;
    case 'curtain':
    default:
      // create the element that will allow proper scrolling when $main is fixed
      $mainShadow = $('<div id="main-spacer"></div>')
        .attr( 'aria-role', 'presentation' )
        .css( 'visibility', 'hidden' )
        .css( 'height', $main.height() )
        .css( 'z-index', '-100')
        .insertAfter( $main )
      ;
      setMainFixed( true ); // set $main to fixed initially, and adjust $mainShadow accordingly
      initCurtainWaypoints(); // set up appropriate waypoints
      break;
  }
}

// make the splash panel fill the window (minus the brand bar)
function setSplashPanelHeight() {
  if ( !$splashPanel ) return;
  var windowHeight      = $( window ).innerHeight()
    , brandBarHeight    = $brandBar.outerHeight()
    , splashPanelHeight = windowHeight - brandBarHeight + 1
  ;

  //console.debug( 'setting splash panel height to ', splashPanelHeight );
  $splashPanel.css( 'height', splashPanelHeight );
}

// adjust the fixed-ness of $main, and make the appropriate changes based on $main's fixed-ness
// for curtain reveal behavior
function setMainFixed( setMainFixed ) {
  if ( setMainFixed ) {
    var isMobileMenu     = feature.mobileMenu()
      , shadowAffordance = 10
      , brandBarHeight   = $brandBar.outerHeight()
      , siteNavHeight    = $siteNav.outerHeight()
      , mainShadowHeight = $mainShadow.outerHeight()

      , mainMarginTop    = isMobileMenu ? brandBarHeight : brandBarHeight + siteNavHeight - shadowAffordance
    ;

    $main.addClass( 'fixed' ).css( 'margin-top', mainMarginTop );
    $mainShadow.css( 'height', mainShadowHeight + mainMarginTop ).css( 'display', 'block' );
    // play video splash when in view, but only if not paused by user
    if ($('#splash-video').length && !$('#splash-video').hasClass('paused') && ($searchToggle.attr('aria-expanded') !== 'true') && ($menuToggle.attr('aria-expanded') !== 'true') ) {
      $('#splash-video')[0].play();
      changeButtonToPause();
    }
  }
  else {
    $main.removeClass( 'fixed' ).css( 'margin-top', 0 );
    $mainShadow.css( 'display', 'none'  );
    // pause video splash when not in view
    if ($('#splash-video').length){
      $('#splash-video')[0].pause();
      changeButtonToPlay();
    }
  }
}

// if splashy is true, make the nav and brandbar look good with the splash panel
// if splashy is false, make the nav and brandbar look like it does without a splash panel
// for parallax scroll behavior
function makeNavSplashy( splashy ) {
  if ( splashy ) {
    $siteNav.removeClass( 'shadow' ).addClass( splashPanelTheme );
    $brandBar.addClass( splashPanelTheme) ;
  } else {
    $siteNav.addClass( 'shadow' ).removeClass( splashPanelTheme );
    $brandBar.removeClass( splashPanelTheme) ;
  }
}

// ---------------------------------------------------------
// Waypoints
// ---------------------------------------------------------

// return the offset waypoints can use to detect the bottom of the nav
function navBottom() {
  // Note that we calculate from the splash panel height, and not from the nav element.
  // This is to avoid weird recalculations when the navigation becomes sticky.
  var splashPanelHeight = $splashPanel.outerHeight()
    , siteNavHeight     = $siteNav.outerHeight()
    , brandBarHeight    = $brandBar.outerHeight()
    , bottomSpacing     = parseFloat( $siteNav.css( "font-size" ) )

    , offset            = splashPanelHeight - siteNavHeight - brandBarHeight - bottomSpacing
  ;
  //console.debug( 'Splash panel waypoint: Nav bottom offset = ', offset );
  return -offset;
}

// configure scroll choreography for curtain reveal
function initCurtainWaypoints() {
  // ---------------------------------------------------------
  // Add shadow to nav
  // ---------------------------------------------------------
  $splashPanel.waypoint(function (direction) {
    //console.debug('Curtain reveal waypoint: $splashPanel crossed bottom of nav, direction = ', direction );
    if (direction === 'down') {
      $siteNav.addClass( 'shadow' ).removeClass( splashPanelTheme );
    } else if (direction === 'up') {
      $siteNav.removeClass( 'shadow' ).addClass( splashPanelTheme );
    }
  }, {
    offset: navBottom
  });

  // ---------------------------------------------------------
  // Curtain reveal
  // ---------------------------------------------------------
  $header.waypoint(function (direction) {
    //console.debug('In splash panel - curtain reveal - main fixed / search wrapper waypoint');
    if ( direction === 'down' ) {
      setMainFixed( false );
      $searchWrapper.removeClass( 'splash' );

      // A better way of handing refreshAll() that doesn't trigger an infinite loop
      // We do this to re-calculate waypoint positions after the DOM has changed.
      Waypoint.disableAll();
      Waypoint.enableAll();

      // TODO: try to connect this event to the analytics $(document).trigger('hsSplashScrollComplete');
    } else if ( direction === 'up' ) {
      setMainFixed( true );
      $searchWrapper.addClass( 'splash' );
    }
  }, {
    offset: function () {
      var offset = feature.mobileMenu()
        ? $splashPanel.outerHeight()
        : $splashPanel.outerHeight() - $brandBar.outerHeight()
      ;
      //console.debug( 'Curtain reveal waypoint offset = ', offset );
      return -offset;
    }
  });
}

// configure scroll choreography for parallax scrolling
function initParallaxWaypoints() {
  // When top of main content touches the bottom of the main site nav
  $splashPanel.waypoint(function (direction) {
    //console.debug('Parallax waypoint: $splashPanel crossed bottom of nav, direction = ', direction );
    var openSiteSearch = feature.siteSearch();
    if (direction === 'down') {
      contentLocation = 'above'; // main content has moved above the nav
      makeNavSplashy( false );
      $searchWrapper.removeClass('splash');
      // pause video splash when not in view
      if ($('#splash-video').length){
        $('#splash-video')[0].pause();
        changeButtonToPlay();
      }
    } else if (direction === 'up') {
      contentLocation = 'within'; // main content is below the nav but still above the CTA, so 'within' the splash panel
      makeNavSplashy( !openSiteSearch ); // if the search overlay is open, make nav un-splashy; if closed, make splashy
      // play video splash when in view, but only if not paused by user and if search or mobile menu aren't expanded
      if ($('#splash-video').length && !$('#splash-video').hasClass('paused') && ($searchToggle.attr('aria-expanded') !== 'true') && ($menuToggle.attr('aria-expanded') !== 'true') ) {
        $('#splash-video')[0].play();
        changeButtonToPause();
      }
    }
  }, {
    offset: navBottom
  });

  // When the top of the main content scrolls past the top of the CTA
  $main.waypoint(function (direction) {
    var openSiteSearch = feature.siteSearch();
    //console.debug('Parallax waypoint: $main crossed top of CTA, direction = ', direction );
    if (direction === 'down') {
      $searchWrapper.removeClass( 'splash' );
      contentLocation = 'within'; // main content is above the CTA but still below the nav, so 'within' the splash panel
      if (openSiteSearch) {
        makeNavSplashy( false );
      }

    } else if (direction === 'up') {
      $searchWrapper.addClass( 'splash' );
      contentLocation = 'below'; // main content has moved above the CTA
      makeNavSplashy( true );
    }
  }, {
    offset: function () {
      var splashScrollerHeight = $splashScroller.outerHeight()
        , offset = $(window).innerHeight() - splashScrollerHeight;

      //console.debug( 'Parallax waypoint: CTA offset = ', offset );
      return offset;
    }
  });
}

// ---------------------------------------------------------
// Custom event handlers
// ---------------------------------------------------------

$(window).on('resizeEnd', function() {
  if ( !$splashPanel ) return;

  var currentBreakpoint  = feature.breakpointDetect()
    , newWindowHeight    = $(window).height()
    , newWindowWidth     = $(window).width()
    , mobileChromeHeight = 95 // approximate height of stuff on mobile devices that hides itself after a short scroll
  ;

  // keep the $mainShadow element as tall as $main
  // test that it's set, because on page load, resizeEnd may be triggered before it's initialized
  if ( typeof $mainShadow == 'object' ) $mainShadow.css( 'height', $main.height() );

  //console.debug( 'resizeEnd: prev height = ', prevWindowHeight, ', prev width = ', prevWindowWidth );
  //console.debug( 'resizeEnd: new  height = ', newWindowHeight,  ', new  width = ', newWindowWidth  );
  // We don't want to recalculate the splash panel height if the resize was caused
  // by the user scrolling a wee bit on a mobile device, causing the mobile browser's
  // address bar and / or toolbar to disappear.
  if ( currentBreakpoint != 'xs' && currentBreakpoint != 'sm' ) {
    // always recalc on tablets and desktops
    setSplashPanelHeight();
  } else if ( newWindowWidth != prevWindowWidth) {
    // recalc on phones if width changes
    setSplashPanelHeight();
  } else if ( Math.abs( newWindowHeight - prevWindowHeight ) > mobileChromeHeight ) {
    // only recalc on phones if height changes more than the height of the chrome
    setSplashPanelHeight();
  }

  prevWindowHeight = newWindowHeight;
  prevWindowWidth  = newWindowWidth;
});


// ---------------------------------------------------------
// Video stuff
// ---------------------------------------------------------

// Change pause button to play
function changeButtonToPlay() {
  $('#splash--pause i').removeClass( 'fa-pause-circle' ).addClass( 'fa-play-circle' );
  $('#splash--pause').attr( 'aria-label', 'Play' );
}

// Change play button to pause
function changeButtonToPause() {
  $('#splash--pause i').removeClass( 'fa-play-circle' ).addClass( 'fa-pause-circle' );
  $('#splash--pause').attr( 'aria-label', 'Pause' );
}

function pauseVideo() {
  changeButtonToPlay();
  $('#splash-video')[0].pause();
}

function playVideo() {
  changeButtonToPause();
  $('#splash-video')[0].play();
}

// Toggle video play/pause when the button or the video panel itself is clicked and add/remove "paused" class to #splash-video
function toggleVideo() {
  if ($('#splash-video')[0].paused) {
    $('#splash-video').removeClass( 'paused' );
    playVideo();
  }
  else {
    $('#splash-video').addClass( 'paused' );
    pauseVideo();
  }
}

// ---------------------------------------------------------
// Document ready
// ---------------------------------------------------------

$(document).ready(function(){
  $splashPanel = objects.splashPanel(); // find the splash panel

  // if there's no splash panel, there's nothing to do here
  if ( !$splashPanel ) return;

  // set shared variables
  $header          = $('body > header');
  $main            = $('#main');
  $footer          = $('body > footer');
  $brandBar        = $('#brand-bar');
  $searchWrapper   = $('#search-wrapper');
  $searchToggle    = $('#search-toggle');
  $menuToggle      = $('#menu-toggle');
  $siteNav         = $('#site-navigation');
  $splashScroller  = $('#splash--scroller');

  splashPanelTheme = $splashPanel.attr( 'class' ).match(/theme--\S+/);
  splashPanelTheme = splashPanelTheme ? splashPanelTheme[0] : 'theme--choco';

  splashPanelScrollType = $splashPanel.attr('data-scroll-type') || 'curtain';

  // save the initial window dimensions
  prevWindowHeight = $(window).height();
  prevWindowWidth  = $(window).width();

  // set initial state
  splashPanelInit();
});