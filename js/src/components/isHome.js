'use strict';
function isHome() {
  var $ = jQuery;
  return $('body').hasClass('home') === true;
}
module.exports = isHome;