'use strict';
var $ = jQuery;

var feature = require('../components/features');

function calcScrollTop( selector ) {
  var hasSplashPanel = feature.splashPanel()
    , $brandBar      = $('#brand-bar')
    , brandBarHeight = $brandBar.outerHeight()
    , $siteNav       = $('#site-navigation')
    , siteNavHeight  = $siteNav.outerHeight()
    , navHeight      = brandBarHeight + siteNavHeight

    , scrollTop = hasSplashPanel
      ? $(window).innerHeight()  - navHeight
      : $(selector).offset().top - navHeight
  ;
  scrollTop = Math.ceil( scrollTop );
  //console.debug( 'calcScrollTop: selector  =', selector );
  //console.debug( 'calcScrollTop: scrollTop =', scrollTop );
  return scrollTop;
}

// add a click handler to all links
// that point to same-page targets (href="#...")
$("a[href^='#']").click( function(ev) {
  var $this            = $(this)
    , target           = $this.attr('href')
    , isSplashScroller = $this.parent('#splash--scroller').length > 0
    , time             = isSplashScroller ? 700 : 400
  ;

  // list filters don't scroll - they filter
  if ( $this.closest( 'ul#list-filters' ).length ) return;

  // we'll do the scrolling, so stop the browser from scrolling
  ev.preventDefault();

  // animate the scroll
  $('html, body').animate({
    scrollTop: calcScrollTop( target )
  }, time);

  // set the focus on the element we linked to
  $(target).focus();

  // manually update the address bar (without reloading!) so people can bookmark it
  history.pushState( null, '', target );
});

window.onload = function() {
  var $skipLink = $( 'skiplinks' )
    , mainContentSelector = $skipLink.length ? $skipLink.attr('href') : '#main-content'
    ;
  $( mainContentSelector ).attr( 'tabindex', '-1' ); // ensure the target of the skiplink can receive focus
  // archive pages are list pages - they handle the hash differently
  if ( window.location.hash && !$('body').hasClass( 'archive' ) ) {
    $('html, body').animate({
      scrollTop: calcScrollTop( window.location.hash )
    }, 250);
  }
};