/**
* Highlights JS
* -----------------------------------------------------------------------------
*
* All the JS for the Highlights component.
*/

/*
 * Example of importing modules if needed. Like for scroll magic / gsap
 */

import {gsap} from 'gsap';
import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
gsap.registerPlugin( ScrollTrigger );
( function( app ) {
  const COMPONENT = {

    className: 'highlights',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
      const sections = gsap.utils.toArray( '.panel' );
      gsap.to( sections, {
        xPercent: -100 * ( sections.length - 1 ),
        ease: 'none',
        scrollTrigger: {
          trigger: '.highlights',
          pin: true,
          markers: true,
          start: 'top top',
          scrub: 1,
          snap: 1 / ( sections.length - 1 ),
          end: () => '+=' + document.querySelector( '.highlights' ).offsetWidth,
        },
      } );
    },
    finalize: function() {
    },
  };

  // Hooks the component into the app
  app.registerComponent( 'highlights', COMPONENT );
} )( app );
