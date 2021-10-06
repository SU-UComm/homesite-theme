'use strict';
var $ = jQuery;

// add :external filter to elements
$.expr[':'].external = function(obj) {
  return obj.hostname && (obj.hostname != document.location.hostname);
};

if (typeof ga == 'function') {
  // add function to send an event to Google Analytics when a link is clicked
  var trackClick = function(elem) {
    var $elem    = $(elem)
      , category = $elem.data('ga-category') || (elem.hostname.match(/stanford\.edu$/) ? 'stanfordLink' : 'externalLink')
      , action   = $elem.data('ga-action')   || ($elem.is('a') && elem.hostname) || 'click'
      , label    = $elem.data('ga-label')    || elem.href
      ;
    //console.log( 'tracking click: category=' + category + ', action=' + action + ', label=' + label ); //// DEBUG
    ga('send', 'event', category, action, label);
  };
  // track clicks on offsite links
  $('a:external').click(function(){ trackClick(this); });

  $('[data-ga-category] a, a[data-ga-category], [data-ga-category] button, button[data-ga-category]').on( 'click', function() { // consider 'click contextmenu' events
    var $this    = $(this)
      , category = $this.closest('[data-ga-category]').data('ga-category')
      , action   = $this.closest('[data-ga-action]').data('ga-action') || 'click'
      , label    = $this.data('ga-label') || ($this.is('a') && this.href) || ( $this.attr('aria-expanded') === 'true' && 'Close' ) || 'Open'
      ;
    //console.log( 'tracking click: category=' + category + ', action=' + action + ', label=' + label ); //// DEBUG
    ga('send', 'event', category, action, label);
  })
}

// note scrolling on the homepage
// TODO: connect this with $(document).one('hsSplashScrollComplete', function() {});
if ($('body.home').length > 0) {
  require('waypoints/lib/jquery.waypoints.js');
  require('waypoints/lib/shortcuts/inview.js');

  var logScroll = function (action, label) {
    console.log('Tracking scroll: category=Homepage scroll, action=' + action + ', label=' + label); //// DEBUG
    ga('send', 'event', 'Homepage scroll', action, label);
  }

  $('section[data-type="section"] > header > h2').each(function (index, elem) {
    new Waypoint.Inview({
      element:   $(elem).closest('section')[0]
      , entered: function (direction) {
        logScroll('Viewed', $(elem).text());
        this.destroy();
      }
    });
  });
}