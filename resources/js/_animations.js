import {gsap} from 'gsap';
import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
import {CustomEase} from 'gsap/CustomEase';
gsap.registerPlugin( ScrollTrigger, CustomEase );
( function( app ) {
  const COMPONENT = {
    init: function() {
      const _this = this;
    },
    finalize: function() {
    },
    animate: function() {
      $( `
      .js-fade:not(.js-ignore),
      .js-reveal:not(.js-ignore),
      .js-fade-group
      ` ).each( function() {
        gsap.registerPlugin( ScrollTrigger );
        const tl = gsap.timeline( {
          scrollTrigger: {
            trigger: this,
            start: 'top 90%',
            scrub: 0.15,
            onRefresh: ( self ) => {
              if ( self.progress > 0 ) {
                $( this ).addClass( 'js-animated' );
              }
            },
            onEnter: ( {progress, direction, isActive} ) => {
              if ( $( this ).hasClass( 'js-fade-group' ) ) {
                $( this ).find( '> *' ).each( function( childKey, child ) {
                  const delay = ( childKey + 1 ) / 10;
                  child.style.setProperty( '--fade-group-delay', delay + 's' );
                } );
              }
              $( this ).addClass( 'js-animated' );
            },
          },
        } );
      } );
    },
    onError: function() {
      document.querySelectorAll( '.js-fade' )?.forEach( ( el ) => {
        el.classList.remove( 'js-fade' );
      } );
    },
  };
  app.registerComponent( 'animations', COMPONENT );
} )( app );
