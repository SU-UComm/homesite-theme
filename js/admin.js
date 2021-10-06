/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 32);
/******/ })
/************************************************************************/
/******/ ({

/***/ 32:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__admin_widgets__ = __webpack_require__(5);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__admin_widgets___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__admin_widgets__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__admin_copyPreview__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__admin_copyPreview___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__admin_copyPreview__);






/***/ }),

/***/ 4:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


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

/***/ }),

/***/ 5:
/***/ (function(module, exports, __webpack_require__) {

"use strict";

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


/***/ })

/******/ });
//# sourceMappingURL=admin.js.map