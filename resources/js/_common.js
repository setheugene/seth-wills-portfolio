/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */
import {gsap} from 'gsap';
// import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
( function( app ) {
  const COMPONENT = {
    init: function() {
      const pxPerSecond = 50;
      gsap.set( '.particle', {backgroundColor: gsap.utils.wrap( ['#589fe4', '#f02d3a', '#51CB20', '#FAC748'] )} );
      $( '.particle' ).each( function() {
        gsap.set( $( this ), {x: gsap.utils.random( 0, ( window.innerWidth * 1.15 ) ), y: gsap.utils.random( 0, ( window.innerHeight * 1.15 ) )} );
      } );
      function moveMe( target ) {
        const newPos = {
          x: gsap.utils.random( 0, ( window.innerWidth * 1.15 ) ),
          y: gsap.utils.random( 0, ( window.innerHeight * 1.15 ) ),
        };
        const curPos = {
          x: gsap.getProperty( target, 'x' ),
          y: gsap.getProperty( target, 'y' ),
        };
        const deltaX = curPos.x - newPos.x;
        const deltaY = curPos.y - newPos.y;
        const distance = Math.hypot( deltaX, deltaY );
        const duration = distance / pxPerSecond;

        const angleDeg = Math.atan2( newPos.y - curPos.y, newPos.x - curPos.x ) * 180 / Math.PI;

        gsap.to( target, {rotation: angleDeg + '_short', duration: 1} );

        gsap.to( target, {x: newPos.x, y: newPos.y, duration: duration, ease: 'none', onComplete: moveMe, onCompleteParams: [target]} );
      }

      gsap.utils.toArray( '.particle' ).forEach( ( el ) => moveMe( el ) );

      // $( 'h2' ).on( 'click', function() {
      //   $( this ).append( '<div class="particle new"></div>' );
      //   gsap.utils.toArray( '.particle.new' ).forEach( ( el ) => moveMe( el ) );
      // } );

      $( '.navbar-toggle' ).on( 'toggleAfter', ( event ) => {
        $( '.primary-nav' ).slideToggle();
      } );

      $( '.js-init-video' ).magnificPopup( {
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false,
        callbacks: {
          open: function() {
            $( 'video' ).trigger( 'pause' );
          },
          close: function() {
            $( 'video' ).trigger( 'play' );
          },
        },
      } );

      function handleMobileChange( event ) {
        /*
         * Remove any inline display values when the screen changes
         * between mobile and desktop state. This allows the default
         * stylings to kick in and prevent any weird "half mobile half desktop"
         * nav display states that sometimes occur while resizing the browser
         * Also remove any active is-open classes from the toggle and nav to reset
         * its state when switching between screen sizes
         */
        if ( event.matches ) {
          if ( $( '.primary-nav' ).length > 0 ) {
            $( '.primary-nav' ).get( 0 ).style.removeProperty( 'display' );

            $( '.navbar-toggle, .primary-nav' ).removeClass( 'is-open' );
          }
        }
      }

      /* Run the handleMobileChange function when the screen sizes changes based on the mobileSize const */
      const mobileSize = window.matchMedia( '(min-width: 768px)' );
      handleMobileChange( mobileSize );
      mobileSize.addEventListener( 'change', handleMobileChange );

      /* Allow selects to have placeholder styles */
      checkSelectPlaceholder();
      $( '.gfield_select' ).on( 'change', function() {
        checkSelectPlaceholder();
      } );
      function checkSelectPlaceholder() {
        if ( $( '.gfield_select' ).find( 'option:selected' ).hasClass( 'gf_placeholder' ) ) {
          $( '.gfield_select' ).addClass( 'placeholder-selected' );
        } else {
          $( '.gfield_select' ).removeClass( 'placeholder-selected' );
        }
      }

      /* Lazyload all embeds */
      if ( 'IntersectionObserver' in window ) {
        const options = {
          root: null, // avoiding 'root' or setting it to 'null' sets it to default value: viewport
          rootMargin: '0px 0px 100px', // determines how far form the root the intersection callback will trigger
        };
        const embedObserver = new IntersectionObserver( function( entries, observer ) {
          entries.forEach( function( embed ) {
            if ( embed.isIntersecting ) {
              $( embed.target ).attr( 'src', $( embed.target ).attr( 'data-src-defer' ) );
              // remove observer
              embedObserver.unobserve( embed.target );
            }
          } );
        }, options );

        // add the observer to the elements
        $( '[data-src-defer]' ).each( function( index, element ) {
          embedObserver.observe( element );
        } );
      }

      /* Set up arias for blog sidebar toggles */
      toggleBlogSidebarAriaVisibility();

      $( window ).on( 'resize', function() {
        toggleBlogSidebarAriaVisibility();
      } );

      function toggleBlogSidebarAriaVisibility() {
        if ( window.innerWidth > 1024 ) {
          $( '.blog__sidebar-inner' ).attr( 'aria-hidden', false );
        } else if ( window.innerWidth <= 1024 && !$( '.blog__sidebar-inner' ).hasClass( 'is-open' ) ) {
          $( '.blog__sidebar-inner' ).attr( 'aria-hidden', true );
        }
      }
    },
    finalize: function() {
    },
  };

  app.registerComponent( 'common', COMPONENT );
} )( app );
