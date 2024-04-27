---
to: resources/js/_<%=h.changeCase.paramCase(name)%>.js
---
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
    },

    finalize: function() {
    },
  };

  app.registerComponent( '<%= h.changeCase.paramCase(name) %>', COMPONENT );
} )( app );
