'use strict';
var $ = jQuery
  , Mousetrap       = require('mousetrap')
  , listHeading     = document.querySelector('#list > h2')
  , mouseTrapBinder = null
  ;

function deleteEmptyFilters( type ) {
  var pageSelector = ( type == 'alpha' ) ? '.post-type-archive-atoz' : '.archive.tax-list' ;
  $( pageSelector + ' #list-filters li' ).each( function() {
    var $this    = $(this)
      , tag      = $this.children( 'a' ).first().data( 'filter' )
      , selector = ( ( type == 'alpha' ) ? '.alpha-group' : '.alpha-group li' ) + '[data-filter="' + tag + '"]'
      ;
    if ( tag != 'all' && $( selector ).length == 0 ) {
      $this.remove();
    }
  } );
}
deleteEmptyFilters( 'alpha' );
deleteEmptyFilters( 'term'  );


// adjust the filters' classes and the screen-reader text when a new filter is activated
function changeFilter( activatedFilter ) {
  $('#list-filters a.current').removeClass('current').find('span').text(' - Tab');
  activatedFilter.addClass('current').find('span').text(' - Tab selected');
}

// make shift-tab from the first visible list item take you to the active filter
function rebindShiftTab( firstVisibleListItem ) {
  // if shift+tab was previously bound to list item, unbind that one
  if ( mouseTrapBinder ) mouseTrapBinder.unbind('shift+tab');

  // now make shift+tab on the firstVisibleItem take you back to the currently selected filter
  mouseTrapBinder = new Mousetrap(firstVisibleListItem); // this is the instance of MouseTrap that will know how to unbind what we're about to bind
  mouseTrapBinder.bind( 'shift+tab', function (ev ) {
    $('#list-filters a.current').focus();
    return false;
  } );
}

// filter individual terms within alpha groups on list pages
$('.archive.tax-list #list-filters a.show-tag').click(function (ev) {
  ev.preventDefault();
  var $this = $(this)
    , tag   = $this.data('filter') // find the tag we want to filter on
    ;

  // first, properly indicate which filter is selected
  changeFilter( $this );

  // next, show / hide the appropriate list items and alpha groups
  if ( tag == 'all' ) {
    // remove the hash from the URL (as much as possible)
    window.location.hash = '';
    // unhide everything
    $('#list .alpha-group, #list li').attr('aria-hidden', 'false');
  } else {
    // put the tag in the hash on the URL (for bookmarking), but don't add it to browser history
    location.replace('#'+tag);
    // hide all the alpha groupings and all the list itmes
    $('#list .alpha-group, #list li').attr('aria-hidden', 'true');
    // unhide the list items that match our tag
    $('#list li[data-filter~=' + tag + ']').attr('aria-hidden', 'false');
    // go through every alpha grouping looking for unhidden list items; if any, then unhide the group
    $('#list .alpha-group').each(function (index, el) {
      var $this = $(this)
        , visibleChildren = $this.find('[aria-hidden="false"]').length
        ;
      if ( visibleChildren ) $this.attr('aria-hidden', 'false');
    })
  }

  // now that we know what list items are visible, make shift-tab from the first visible
  // list item take you to the active filter
  var firstVisibleListItem = document.querySelector('#list li[aria-hidden="false"] a'); // :first-of-type seems to be unnecessary
  rebindShiftTab( firstVisibleListItem );

  // finally, put the focus on the list of websites (there's an h2.sr-only-element there)
  $('#list > h2').focus();
});

// filter entire alpha groups on the A-Z index page
$('.post-type-archive-atoz #list-filters a.show-tag').click(function (ev) {
  ev.preventDefault();
  var $this = $(this)
    , tag   = $this.data('filter') // find the tag we want to filter on
    ;

  // first, properly indicate which filter is selected
  changeFilter( $this );

  // next, show / hide the appropriate list items and alpha groups
  if ( tag == 'all' ) {
    // remove the hash from the URL (as much as possible)
    window.location.hash = '';
    // unhide everything
    $('#list .alpha-group, #list li').attr('aria-hidden', 'false');
  } else {
    // put the tag in the hash on the URL (for bookmarking), but don't add it to browser history
    location.replace('#'+tag);
    // hide all the alpha groupings
    $('#list .alpha-group').attr('aria-hidden', 'true');
    // unhide the alpha group that matches our tag
    $('#list .alpha-group[data-filter=' + tag + ']').attr('aria-hidden', 'false');
  }

  // now that we know what list items are visible, make shift-tab from the first visible
  // list item take you to the active filter
  var firstVisibleListItem = document.querySelector('#list div.alpha-group[aria-hidden="false"] a'); // :first-of-type seems to be unnecessary
  rebindShiftTab( firstVisibleListItem );

  // finally, put the focus on the list of websites (there's an h2.sr-only-element there)
  $('#list > h2').focus();
});


// When a filter is activated, focus is moved to an h2.sr-only-element (which is tab-index="-1").
// If the user hits shift+tab while on that element, focus should return to the filter they just activated.
if ( listHeading ) {
  Mousetrap(listHeading).bind('shift+tab', function () {
    $('#list-filters a.current').focus();
    return false;
  });
}

// handle bookmarked hash
if (window.location.hash !== '') {
  var hash = window.location.hash.substr(1); // get the hash value (skip the #)
  // click on the corresponding filter
  if ( hash) {
    $('#list-filters a.show-tag[data-filter="'+hash+'"]').click();
  }
}
