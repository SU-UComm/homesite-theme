'use strict';

var $ = jQuery;

module.exports = {
  breakpointDetect: function() {
    var body       = document.querySelector('body')
      , result     = getComputedStyle(body, ':before').content;
    // returns contents without quotes
    return result.replace(/\"/g, "");
  },
  homePage: function () {
    var $body = $( 'body' );
    return $body.hasClass('page-template-homepage') || ( $body.hasClass('home') && !$body.hasClass('emergency-home') );
  },
  emergencyPage: function () {
    return $('body').hasClass('page-template-emergency-page');
  },
  mobileMenu: function() {
    var currentBreakpoint = module.exports.breakpointDetect();
    return ( currentBreakpoint === 'xs' || currentBreakpoint === 'sm' || currentBreakpoint === 'md' );
  },
  splashPanel: function () {
    return $( 'body' ).attr( 'class' ).match(/splash-/) ? true : false;
  },
  splashCurtain: function () {
    return $( 'body' ).hasClass( 'splash-curtain' );
  },
  splashParallax: function () {
    return $( 'body' ).hasClass( 'splash-parallax' );
  },
  siteSearch: function() {
    return ( $( '#site-search' ).attr('aria-expanded') == 'true' );
  },
  alertWidget: function () {
    return $('body > header .widget_alert').length > 0;
  }
};