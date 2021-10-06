'use strict';
var $ = jQuery;

function highlightHover( elem, on ) {
  var highlight = $(elem).closest('.highlight');
  if ( on ) {
    highlight.attr('data-hover', 'true');
  } else {
    highlight.removeAttr('data-hover');
  }
}
function highlightHoverOn() {
  highlightHover( this, true );
}
function highlightHoverOff() {
  highlightHover( this, false );
}

$(".highlight .highlight-link").each(function() {
  var $this = $(this);
  if ( $this.closest('.highlight').find('a picture').length > 0 ) {
    $this.on('mouseover focusin',  highlightHoverOn);
    $this.on('mouseout  focusout', highlightHoverOff);
  }
});

$(".highlight a picture").each(function() {
  var $this = $(this);
  if ( $this.closest('.highlight').find('.highlight-link').length > 0 ) {
    $this.on('mouseover focusin',  highlightHoverOn);
    $this.on('mouseout  focusout', highlightHoverOff);
  }
});
