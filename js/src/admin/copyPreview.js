'use strict';

var $ = jQuery;

// JS that handles the "Copy preview to live" and "Copy live to preview" buttons that
// appear when editing the Homepage Preview page

$('#copy-buttons .inside a').click( function (ev) {
  ev.preventDefault();
  ev.stopPropagation();
  var $this  = $(this)
    , pageID = $this.data( 'page-id' )
    , elemID = this.id
    , action = (elemID == 'copyl2p') ? "live to preview" : "preview to live"
  ;
  if ( window.confirm( 'Do you really want to copy ' + action + '?' ) ) {
    $.ajax({
        'url':      hs17.ajaxurl // url made available by wp_localize_script
      , 'dataType': 'json'
      , 'type':     'POST'
      , 'data':     "action=copypost" + "&do=" + elemID + "&page=" + pageID + "&hs_nonce=" + hs17.nonce
    })
      .done(function(response){
        console.log( 'AJAX succeeded' );
        console.log( response );
        if (response.status == 'success') {
          var msg = 'Success! ' + response.message;
          if ( elemID == 'copyl2p' ) msg += ' Please wait while this page reloads in order to show the new content.';
          alert( msg );
          // if we've updated this page, reload it to get the new data
          if ( elemID == 'copyl2p' ) window.location.reload( true );
        } else {
          alert( 'ERROR: '   + response.message );
        }
      })
      .fail(function( jqXHR, textStatus ) {
        console.log( 'AJAX failed' );
        console.log( jqXHR );
        alert( 'ERROR: ' + textStatus );
      });
  }
  return false; // no idea why ev.preventDefault() and ev.stopPropagation() aren't sufficient???
});