'use strict';

$ = jQuery;

module.exports = {
  splashPanel: function() {
    var $splashPanel = $('body > header .panel[data-type^="splash-"]');
    return ( $splashPanel.length ) ? $splashPanel : false;
  },

  splashCurtain: function() {
    var $splashCurtain = $('body > header .panel[data-scroll-type*="curtain"]');
    return ( $splashCurtain.length ) ? $splashCurtain : false;
  },

  splashParallax: function() {
    var $splashParallax = $('body > header .panel[data-scroll-type*="parallax"]');
    return ( $splashParallax.length ) ? $splashParallax : false;
  }

};
