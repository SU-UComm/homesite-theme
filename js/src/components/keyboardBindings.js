'use strict';

var $ = jQuery
  , Mousetrap             = require('mousetrap')
  , feature               = require('./features')
  , hasSplashPanel        = feature.splashPanel()
  , isHome                = feature.homePage()
  , isMobileMenu          = feature.mobileMenu()
  , object                = require('./objects')

  , $splashPanel          = object.splashPanel()
  , searchField           = document.getElementById('search-field')
  , menuToggle            = document.getElementById('menu-toggle')
  , searchToggle          = document.getElementById('search-toggle')
  , lastGatewayLink       = document.querySelector('#menu-gateway-nav li:last-of-type a')
  , lastSearchLink        = document.querySelector('#site-search p a:last-of-type')
  , firstMenuItem         = document.querySelector("#site-navigation li:first-child a")
  , splashScroller        = document.getElementById("splash--scroller")

  , brandBar              = $('#brand-bar')
  , main                  = $('#main')
  , mainContent           = $('#main-content')
  , $searchToggle         = $('#search-toggle')
  , siteNav               = $('#site-navigation')

  , splashPanelHeight     = $($splashPanel).outerHeight()
  , brandBarHeight        = $(brandBar).outerHeight()
  , navHeight             = $(siteNav).outerHeight()
  , $menuToggle           = $(menuToggle)

  , lastGatewayLinkBinding = null
  , menuToggleBinding      = null
  , firstMenuItemBinding   = null
  , splashScrollerBinding  = null
  ;

$(window).on('navKeyboardBindings', function () {
  // ---------------------------------------------------------
  // Bind keyboard navigation to mobile nav
  // ---------------------------------------------------------
  if ( feature.mobileMenu() ) {
    if ( lastGatewayLink ) {
      if ( lastGatewayLinkBinding ) lastGatewayLinkBinding.unbind( 'tab' );

      // move focus from the last item in the gateway nav to the menu toggle button on tab
      lastGatewayLinkBinding = new Mousetrap( lastGatewayLink ).bind( 'tab', function () {
        if ( $menuToggle.attr( 'aria-expanded' ) === 'true' ) {
          menuToggle.focus();
          return false;
        } else {
          return true;
        }
      });
    }

    // move focus from the first item in the primary nav to the menu toggle button on shift+tab
    firstMenuItemBinding = new Mousetrap(firstMenuItem).bind('shift+tab', function () {
      if ($menuToggle.attr('aria-expanded') === 'true') {
        menuToggle.focus();
        return false;
      } else {
        return true;
      }
    });

    // move focus from the menu toggle button to the first item in the primary nav on tab
    menuToggleBinding = new Mousetrap(menuToggle).bind('tab', function () {
      if ($menuToggle.attr('aria-expanded') === 'true') {
        firstMenuItem.focus();
        return false;
      } else {
        return true;
      }
    });
    // move focus from the menu toggle button to the last item in the gateway nav on shift + tab
    menuToggleBinding.bind('shift+tab', function () {
      if ($menuToggle.attr('aria-expanded') === 'true' && lastGatewayLink) {
        lastGatewayLink.focus();
        return false;
      } else {
        return true;
      }
    });
  } else {
    if ( lastGatewayLink ) {
      if ( lastGatewayLinkBinding ) lastGatewayLinkBinding.unbind( 'tab' );
      if ( firstMenuItemBinding ) lastGatewayLinkBinding.unbind( 'shift+tab');
    }
    if ( menuToggleBinding      ) {
      menuToggleBinding.unbind('tab');
      menuToggleBinding.unbind('shift+tab');
    }
  }
  if ( splashScroller ) {
    if ( splashScrollerBinding ) splashScrollerBinding.unbind('tab');
    splashScrollerBinding = new Mousetrap(splashScroller).bind('tab', function () {
      if (hasSplashPanel && isHome) {
        $('html body').animate({
          scrollTop: $(mainContent).offset().top + splashPanelHeight - navHeight - brandBarHeight
        }, 400);
        $(mainContent).focus();
      }
    });
  }
});
$(this).trigger('navKeyboardBindings'); // trigger on document.ready()

// ---------------------------------------------------------
// Bind 'esc' to close open search overlay
// ---------------------------------------------------------

// make esc close any open toggles
Mousetrap().bind('esc', function () {
  if ($searchToggle.attr('aria-expanded') === 'true') {
    $searchToggle.click();
    return false;
  }
  else if ($menuToggle.attr('aria-expanded') === 'true') {
    menuToggle.click();
    return false;
  }
  return true;
});


// Also bind 'esc' to close the search overlay when inside the search field
Mousetrap(searchField).bind('esc', function () {
  if ($searchToggle.attr('aria-expanded') === 'true') {
    $searchToggle.click();
    return false;
  } else {
    return true;
  }
});

Mousetrap(lastSearchLink).bind('tab', function () {
  if ($searchToggle.attr('aria-expanded') === 'true') {
    $searchToggle.focus();
    return false;
  } else {
    return true;
  }
});

Mousetrap(lastSearchLink).bind('tab', function () {
  if ($searchToggle.attr('aria-expanded') === 'true') {
    $searchToggle.focus();
    return false;
  } else {
    return true;
  }
});

Mousetrap(searchToggle).bind('shift+tab', function () {
  if ($searchToggle.attr('aria-expanded') === 'true') {
    $(lastSearchLink).focus();
    return false;
  } else {
    return true;
  }
});

Mousetrap(searchToggle).bind('tab', function () {
  if ($searchToggle.attr('aria-expanded') === 'true') {
    $(searchField).focus();
    return false;
  } else {
    return true;
  }
});

Mousetrap(searchField).bind('shift+tab', function () {
  if ($searchToggle.attr('aria-expanded') === 'true') {
    $(searchToggle).focus();
    return false;
  } else {
    return true;
  }
});
