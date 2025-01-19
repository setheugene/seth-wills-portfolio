/**
* Hero Banner JS
* -----------------------------------------------------------------------------
*
* All the JS for the Hero Banner component.
*/

/*
 * Example of importing modules if needed. Like for scroll magic / gsap
 */
import {gsap} from 'gsap';
import {SplitText} from 'gsap/SplitText';
gsap.registerPlugin( SplitText );
( function( app ) {
  const COMPONENT = {

    className: 'hero-banner',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
      const slides = $( '.hero-banner__slide' );
      const images = $( '.hero-banner__image' );
      const contents = $( '.hero-banner__content h1' );

      contents.split = new SplitText( contents, {
        type: 'words',
        wordsClass: 'split-word',
      } );

      images.each( function( i, ele ) {
        if ( i !== 0 ) {
          gsap.set( ele, {yPercent: 100} );
        } else {
          gsap.set( ele, {yPercent: 0} );
        }
        gsap.set( ele, {opacity: 1} );
      } );

      contents.each( function( i, ele ) {
        if ( i !== 0 ) {
          gsap.set( $( this ).find( '.split-word' ), {yPercent: 200} );
        } else {
          gsap.set( $( this ).find( '.split-word' ), {yPercent: 0} );
        }
        gsap.set( ele, {opacity: 1} );
      } );

      let activeIndex = 0;

      function goToNext() {
        const activeContent = contents[activeIndex];
        let nextContent = contents[activeIndex + 1];

        const activeImage = images[activeIndex];
        let nextImage = images[activeIndex + 1];

        gsap.to( activeImage, {yPercent: 100, delay: 0.15} ),
        gsap.to( activeContent.children, {yPercent: 200, opacity: 0} );


        if ( activeIndex + 1 === slides.length ) {
          activeIndex = 0;
          nextContent = contents[0];
          nextImage = images[0];
        } else {
          activeIndex ++;
        }

        gsap.to( nextImage, {yPercent: 0, delay: 0.15} ),
        gsap.to( nextContent.children, {yPercent: 0, stagger: .2, opacity: 1}, '>.15' );
      }
      // setInterval( goToNext, 6000 );
      $( '.hero-banner__button' ).on( 'click', goToNext );
    },
    finalize: function() {
    },
  };

  // Hooks the component into the app
  app.registerComponent( 'hero-banner', COMPONENT );
} )( app );
