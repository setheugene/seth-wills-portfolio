---
to: components/<%= h.changeCase.paramCase(name) %>/<%= h.changeCase.paramCase(name) %>.js
---
/**
* <%= name %> JS
* -----------------------------------------------------------------------------
*
* All the JS for the <%= name %> component.
*/

/*
 * Example of importing modules if needed. Like for scroll magic / gsap
 */

// import {gsap} from 'gsap';
// import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
// gsap.registerPlugin( ScrollTrigger );
( function( app ) {
  const COMPONENT = {

    className: '<%= h.changeCase.paramCase(name) %>',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
    },
    finalize: function() {
    },
  };

  // Hooks the component into the app
  app.registerComponent( '<%= h.changeCase.paramCase(name) %>', COMPONENT );
} )( app );
