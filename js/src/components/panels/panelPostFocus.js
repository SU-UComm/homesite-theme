'use strict';
var $ = jQuery;

$(".panel[data-type='posts'] article picture, .panel[data-type='posts'] article h3 a, .panel[data-type='posts'] article[data-type='social-post'] .content a:last-of-type").each(function() {
  var $this = $(this);

  $this.on('mouseover focusin', function() {
    $this.closest('article').attr('data-hover', 'true');
    $this.closest('article').find('picture').attr('data-hover', 'true');
  });
  $this.on('mouseout focusout', function() {
    $this.closest('article').removeAttr('data-hover');
    $this.closest('article').find('picture').removeAttr('data-hover');
  });
});