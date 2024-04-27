/**
* LL JS
* -----------------------------------------------------------------------------
*
* This is the core of the LLJS system. It's a combination of a couple things,
* DOM-based routing, module-export pattern, and component-driven development.
*
* The goal is to allow component JS to exist within the component's folder
* and only firing if that component is being used on the page.
*/

( function( $ ) {
  /**
   * The main app.
   *
   * @type {Object}
   */
  const app = {

    components: {},

    registerComponent: function( componentName, component ) {
      this.components[componentName] = component;
    },
  };

  window.app = app;

  // Global variable on the window that returns true if prefers reduced motion is turned off
  window.hasMotion = window.matchMedia( '(prefers-reduced-motion: no-preference)' ).matches;

  window.toggleGridOverlay = function() {
    const template = `<div id="gridOverlay" class="fixed inset-0 opacity-25 pointer-events-none" style="z-index:9999">
        <div class="container grid grid-cols-6 h-full md:grid-cols-12 gap-gutter-full">
          <div class="h-full" style="background-color: #fc8181;"></div>
          <div class="h-full" style="background-color: #fc8181;"></div>
          <div class="h-full" style="background-color: #fc8181;"></div>
          <div class="h-full" style="background-color: #fc8181;"></div>
          <div class="h-full" style="background-color: #fc8181;"></div>
          <div class="h-full" style="background-color: #fc8181;"></div>
          <div class="hidden h-full md:block" style="background-color: #fc8181;"></div>
          <div class="hidden h-full md:block" style="background-color: #fc8181;"></div>
          <div class="hidden h-full md:block" style="background-color: #fc8181;"></div>
          <div class="hidden h-full md:block" style="background-color: #fc8181;"></div>
          <div class="hidden h-full md:block" style="background-color: #fc8181;"></div>
          <div class="hidden h-full md:block" style="background-color: #fc8181;"></div>
        </div>
      </div>`;
    if ( document.getElementById( 'gridOverlay' ) ) {
      document.getElementById( 'gridOverlay' ).remove();
    } else {
      document.body.insertAdjacentHTML( 'beforeend', template );
    }
  };

  // The routing fires all common scripts, followed by the component-specific
  // scripts. Add additional events for more control over
  // timing e.g. a finalize event
  const UTIL = {
    fire: function( func, funcname, args ) {
      let fire;
      const namespace = app.components;
      funcname = ( funcname === undefined ) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if ( fire ) {
        namespace[func][funcname]( args );
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire( 'common' );

      let components = [];

      $( '[data-component]' ).each( function( index, el ) {
        components.push( $( this ).attr( 'data-component' ) );
      } );

      // Unique components only
      components = [...new Set( components )];

      // Fire component-specific init JS, and then finalize JS
      $.each( components, function( i, classnm ) {
        UTIL.fire( classnm );
        UTIL.fire( classnm, 'finalize' );
      } );

      UTIL.fire( 'animations', 'animate' );

      // Fire common finalize JS
      UTIL.fire( 'common', 'finalize' );
    },
  };

  // Load Events
  $( function() {
    window.onerror = () => {
      UTIL.fire( 'animations', 'onError' );
      return true;
    };

    UTIL.loadEvents();
  } );
} )( jQuery );
