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
      const _this = this;
      const copyButton = document.querySelector( '.social-share__link.share-link' );

      copyButton?.addEventListener( 'click', () => {
        /* Please ensure you are on https for this to work */
        navigator.clipboard.writeText( copyButton.dataset.url )
            .then( () => {
              const copied = copyButton.parentElement.querySelector( '.copied-text' );

              copied.classList.add( 'is-copied' );

              setTimeout( function() {
                copied.classList.remove( 'is-copied' );
              }, 2000 );
            } )
            .catch( () => {
              console.log( 'Failed to copy text.' );
            } );
      } );
    },

    finalize: function() {
    },
  };

  app.registerComponent( 'blog', COMPONENT );
} )( app );
