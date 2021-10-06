'use strict';
var $ = jQuery;

if ( window.location.hostname.indexOf('stanford.edu') < 0 ) { // if we're not on (www.)stanford.edu
  $('body').append('<aside id="breakpoint-helper" tabindex="-1" aria-hidden="true"></aside>').addClass('bp-helper');
}