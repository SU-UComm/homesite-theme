'use strict';
function retrieveSplashPanel() {
  var $ = jQuery;

  var isHeaderSplashPanel = require('./isHeaderSplashPanel');
  var hasSplashPanel = isHeaderSplashPanel();

  if (hasSplashPanel === true) {
    var headerPanels = $('body > header .panel');

    if ($(headerPanels).attr('data-type') === 'splash-image') {
      return $('body > header .panel[data-type="splash-image"]');
    } else if ($(headerPanels).attr('data-type') === 'splash-video') {
      return $('body > header .panel[data-type="splash-video"]');
    }
  }
}

module.exports = retrieveSplashPanel;