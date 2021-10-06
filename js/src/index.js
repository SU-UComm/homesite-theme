'use strict';

// Modernizr with HTML5 shiv
import './components/modernizr';

// Click tracking
import './components/analytics';

// Fastclick
import './components/fastclick';

// Hotjar
// import './components/hotjar';

// Alerts
import './components/alerts';

// Picturefill (responsive images polyfill)
// The WP Retina 2x plugin loads this
import './components/picturefill';

// Move Admin Bar to bottom
import './components/adminBar';

// Functions
import  './components/conditionalBreakpointHelper';
import  './components/navMenuToggle';
import  './components/searchBehavior';
import  './components/keyboardBindings';

// Event handlers
import  './eventHandlers/resizeEnd';
import  './eventHandlers/scrollActions';
import  './eventHandlers/skipLinks';


// List filters
import './components/listFilter';

// Panels
import  './components/panels/splashPanel'; // Splash Panel Initial Choreography
import  './components/panels/panelEventFocus'; // Events Panel
import  './components/panels/panelHeroImageFocus'; // Hero Image panel
import  './components/panels/panelImageContentSize'; // Highlights panel
import  './components/panels/panelPostFocus'; // Posts panel
import  './components/panels/panelSubscribeSR'; // Subscribe to SR panel
import  './components/panels/panelProfile'; // Profile panel choreography
import  './components/panels/panelPostObjectFitIE'; // CSS object-fit and object-position for IE


$(window).trigger('resizeEnd'); // trigger resize End after all our JS is loaded