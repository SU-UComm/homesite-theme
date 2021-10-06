'use strict';
var $ = jQuery;
var formText = {
    'web': {
      'button':      '<i class=\"fa fa-globe\"><\/i>&nbsp;Search Web',
      'placeholder': '\uf002\u00a0\u00a0\u00a0 Search Stanford websites'
    },
    'people': {
      'button':      '<i class=\"fa fa-users\"><\/i>&nbsp;Search people',
      'placeholder': '\uf002\u00a0\u00a0\u00a0 Search by name, SUNet, email\u2026'
    }
  }
;

$( 'input[name="search_type"]' ).on( 'change', function() {
  var $this       = $(this),
    $searchForm   = $this.closest( 'form' ),
    $searchField  = $searchForm.find( 'input[type="text"]' ),
    $searchButton = $searchForm.find( 'button' ),
    domain        = $this.attr( 'value' ),
    text          = formText[ domain ]
  ;
  $searchField.attr( 'placeholder', text.placeholder );
  $searchButton.html( text.button );
} );

if ( $('.page-template-search-php').length === 0 ) {
  $('#search-toggle, #search-overlay').click(function () {
    var $searchToggle           = $('#search-toggle')
      , $targets                = $('#search-toggle, #site-search, #search-overlay')
      , $menuToggle             = $('#menu-toggle')
      , $blurTargets            = $('#main, footer, .panel[data-type="splash-image"] img, #splash--wordmark, #splash--scroller')
      ;
    if ( $searchToggle.attr('aria-expanded') === 'true' ) {
      $targets.attr( 'aria-expanded', 'false' );
      $searchToggle.html( 'Search' ).blur();
      $searchToggle.trigger( 'close' );
      $blurTargets.removeClass( 'blur' );
    } else {
      // close the menu if it's open
      if ( $menuToggle.attr('aria-expanded') === 'true' ) {
        $menuToggle.click();
      }
      $targets.attr( 'aria-expanded', 'true' );
      $searchToggle.trigger( 'open' );
      $searchToggle.html( 'Close' );
      $('#search-field').focus();
      $blurTargets.addClass( 'blur' );
    }
  });
} else {
  // don't do the toggle on the search page
  $('#search-toggle').attr('tabindex', '-1');
}