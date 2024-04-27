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
( function( app ) {
  const COMPONENT = {
    init: function() {
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
