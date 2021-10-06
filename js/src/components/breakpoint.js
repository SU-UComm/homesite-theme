'use strict';

function breakpoint() {
  var body      = document.querySelector('body'),
    result    = getComputedStyle(body, ':before').content;

  // returns contents without quotes
  return result.replace(/\"/g, "");
}

module.exports = breakpoint;
