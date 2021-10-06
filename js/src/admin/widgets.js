'use strict';
var $ = jQuery;

var bindHandlers = function() {

  $('.info_box_widget_icon').blur(function(ev){
    this.value = this.value.trim();
    if (this.value.match(/^fa-[-a-z]+$/)) {
      $(this).next('span').attr('class', 'fa fa-2x ' + this.value);
    } else {
      $(this).next('span').attr('class', 'fa fa-2x');
    }
  });

};

$(document).ready( bindHandlers );

// When a new widget is added, there's a new instance of the field -
// we need to bind the handler to that new instance.
$(document).on( 'widget-added', bindHandlers );
// Apparently, when a widget is updated, the widget's form is recreated.
// That means there's a new instance of the field, so we need to bind
// the handler to that new instance.
$(document).on( 'widget-updated', bindHandlers );
