/**
* Projects JS
* -----------------------------------------------------------------------------
*
* All the JS for the Projects component.
*/

/*
 * Example of importing modules if needed. Like for scroll magic / gsap
 */

import {gsap} from 'gsap';
import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
import {Flip} from 'gsap/Flip.js';
gsap.registerPlugin( ScrollTrigger );
gsap.registerPlugin( Flip );
( function( app ) {
  const COMPONENT = {

    className: 'projects',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
      const tiles = gsap.utils.toArray( '.grid-tile' );
      let active = tiles[0];

      tiles.forEach( ( el ) => {
        el.addEventListener( 'click', () => changeGrid( el ) );
      } );

      function changeGrid( el ) {
        if ( el === active ) return;

        const state = Flip.getState( tiles );
        active.dataset.grid = el.dataset.grid;
        el.dataset.grid = 'tile-1';
        active = el;

        Flip.from( state, {
          duration: 0.85,
          absolute: true,
          ease: 'power3.inOut',
        } );
      }
    },
    finalize: function() {
    },
  };

  // Hooks the component into the app
  app.registerComponent( 'projects', COMPONENT );
} )( app );
