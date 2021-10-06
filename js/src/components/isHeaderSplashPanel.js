'use strict';
var $ = jQuery;

function $headerSplashPanel() {
  var $headerPanels = $('body > header .panel');
  return ( $( $headerPanels ).attr('data-type') === 'splash-image' || $( $headerPanels ).attr('data-type') === 'splash-video') === true;
}

module.exports = $headerSplashPanel;