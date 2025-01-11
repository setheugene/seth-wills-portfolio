/**
* Projects JS
* -----------------------------------------------------------------------------
*
* All the JS for the Projects component.
*/

/*
 * Example of importing modules if needed. Like for scroll magic / gsap
 */

// import {gsap} from 'gsap';
// import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
// gsap.registerPlugin( ScrollTrigger );
( function( app ) {
  const COMPONENT = {

    className: 'projects',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
      const projects = $( '.projects__title' );
      projects.each( function() {
        const target = $( this ).data( 'target' );
        $( this ).on( 'mouseover', function() {
          $( target ).css( 'opacity', 1 );
        } );
        $( this ).on( 'mouseout', function() {
          $( target ).css( 'opacity', 0 );
        } );
      } );
    },
    finalize: function() {
    },
  };

  // Hooks the component into the app
  app.registerComponent( 'projects', COMPONENT );
} )( app );
