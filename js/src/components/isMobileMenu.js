'use strict';

function isMobileMenu() {
  var breakpoint = require('./breakpoint');
  var currentBreakpoint = breakpoint();

  if ( currentBreakpoint === 'xs' || currentBreakpoint === 'sm' || currentBreakpoint === 'md' ) {
    return true;
  }
}

module.exports = isMobileMenu;