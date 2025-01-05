/**
* Technologies JS
* -----------------------------------------------------------------------------
*
* All the JS for the Technologies component.
*/

/*
 * Example of importing modules if needed. Like for scroll magic / gsap
 */

// import {gsap} from 'gsap';
// import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
// gsap.registerPlugin( ScrollTrigger );
import Splide from '@splidejs/splide';
import {AutoScroll} from '@splidejs/splide-extension-auto-scroll';
( function( app ) {
  const COMPONENT = {

    className: 'technologies',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
      if ( $( '.technologies__top-splide' ).length > 0 && $( '.technologies__bottom-splide' ).length > 0 ) {
        $( '.technologies' ).each( function( index, element ) {
          const topSlider = new Splide( $( this ).find( '.technologies__top-splide' )[0], {
            type: 'loop',
            gap: '8px',
            perPage: 4,
            pagination: false,
            arrows: false,
            autoScroll: {
              speed: -.5,
              pauseOnHover: false,
            },
            breakpoints: {
              1024: {
                perPage: 3,
              },
              768: {
                perPage: 2,
              },
            },
          } );
          const bottomSlider = new Splide( $( this ).find( '.technologies__bottom-splide' )[0], {
            type: 'loop',
            gap: '8px',
            perPage: 4,
            pagination: false,
            arrows: false,
            autoScroll: {
              speed: .5,
              pauseOnHover: false,
            },
            breakpoints: {
              1024: {
                perPage: 3,
              },
              768: {
                perPage: 2,
              },
            },
          } );
          topSlider.mount( {AutoScroll} );
          bottomSlider.mount( {AutoScroll} );
          $( this ).find( '.technologies__sliders-wrapper' ).on( 'mouseover', function() {
            topSlider.Components.AutoScroll.pause();
            bottomSlider.Components.AutoScroll.pause();
          } );
          $( this ).find( '.technologies__sliders-wrapper' ).on( 'mouseout', function() {
            topSlider.Components.AutoScroll.play();
            bottomSlider.Components.AutoScroll.play();
          } );
        } );
      }
    },
    finalize: function() {
    },
  };

  // Hooks the component into the app
  app.registerComponent( 'technologies', COMPONENT );
} )( app );
