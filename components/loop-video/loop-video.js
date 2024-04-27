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
    className: 'loop-video',
    selector: function() {
      return '.' + this.className;
    },
    init: function() {
      const _this = this;


      // switches the data-src to the src of the source element
      const switchSource = ( video ) => {
        $( video ).children().each( function( index, source ) {
          if ( $( source ).is( 'source' ) ) {
            source.src = $( source ).attr( 'data-src' );
          }
        } );
      };

      // get all looping videos
      const lazyVideos = $( 'video.lazy:not(.delay)' );

      // check that the observer exists and create the observer to detect if the video is in the window
      if ( 'IntersectionObserver' in window ) {
        const lazyVideoObserver = new IntersectionObserver( function( entries, observer ) {
          entries.forEach( function( video ) {
            if ( video.isIntersecting ) {
              // play if its desktop and the video is desktop only
              if ( $( video.target ).hasClass( 'desktop' ) && window.matchMedia( '(min-width: 768px)' ).matches ) {
                switchSource( video.target );
                if ( window.hasMotion ) {
                  $( video.target )[0].load();
                }
              } else if ( $( video.target ).hasClass( 'mobile' ) ) {
                switchSource( video.target );
                $( video.target )[0].load();
              }

              // remove lazy loading class
              $( video.target ).removeClass( 'lazy' );

              // remove observer
              lazyVideoObserver.unobserve( video.target );
            }
          } );
        } );

        // add the observer to the video
        $( lazyVideos ).each( function( index, element ) {
          lazyVideoObserver.observe( element );

          // add eventlistener for when the video has loaded data
          $( element ).on( 'loadeddata', function( e ) {
            if ( element.readyState >= 3 && !$( this ).parents( '.video-image-container' ).children( '.loop-video-image' ).hasClass( 'image-fade' ) ) {
              $( this ).parents( '.video-image-container' ).children( '.loop-video-image' ).addClass( 'image-fade' );
              $( this ).removeClass( 'is-paused' );
              if ( $( this ).closest( 'section' ).find( '.loop-video-toggle-state' ).length > 0 ) {
                $( this ).closest( 'section' ).find( '.loop-video-toggle-state' ).attr( 'title', 'Pause looping video' );
                $( this ).closest( 'section' ).find( '.loop-video-toggle-state' ).removeClass( 'is-paused' );
              }
            }
          } );
        } );
      }


      // Handles showing / hiding image and play/pausing video when display is set to desktop
      const mobileSize = window.matchMedia( '(min-width: 768px)' );
      handleMobileChange( mobileSize );
      mobileSize.addEventListener( 'change', handleMobileChange );

      function handleMobileChange( event ) {
        const desktopVideos = $( 'video.desktop' );
        if ( desktopVideos.length > 0 && window.hasMotion ) {
          desktopVideos.each( function( index, video ) {
            if ( event.matches ) {
              // update video and image for desktop
              // check if the video has a source or if it is paused
              if ( ( $( video ).children().is( 'source' ) && !$( video ).children().attr( 'src' ) || $( video ).hasClass( 'is-paused' ) ) ) {
                $( video ).closest( 'section' ).find( '.loop-video-toggle-state' ).trigger( 'click' );
              }
            } else {
              // update video and image for mobile
              if ( !$( video ).hasClass( 'is-paused' ) ) {
                $( video ).closest( 'section' ).find( '.loop-video-toggle-state' ).trigger( 'click' );
              }
              if ( $( video ).parents( '.video-image-container' ).children( '.loop-video-image' ).hasClass( 'image-fade' ) ) {
                $( video ).parents( '.video-image-container' ).children( '.loop-video-image' ).removeClass( 'image-fade' );
              }
            }
          } );
        }
      }

      // play video button
      $( document ).on( 'click', '.loop-video-toggle-state', function() {
        // get the video
        const video = $( this ).closest( 'section' ).find( '.loop-video' );

        // add the src if video doesn't have it
        if ( $( video ).children().is( 'source' ) && !$( video ).children().attr( 'src' ) ) {
          switchSource( video );
        }

        if ( video.hasClass( 'is-paused' ) ) {
          // update video attritbutes
          $( this ).attr( 'title', 'Pause looping video' );
          $( this ).removeClass( 'is-paused' );

          video.removeClass( 'is-paused' );
          // check if the video has ever been loaded
          if ( video[0].readyState === 0 ) {
            video[0].load();
          } else {
            video[0].play();
            if ( !$( video ).parents( '.video-image-container' ).children( '.loop-video-image' ).hasClass( 'image-fade' ) ) {
              $( video ).parents( '.video-image-container' ).children( '.loop-video-image' ).addClass( 'image-fade' );
            }
          }
        } else {
          // update video attributes
          $( this ).attr( 'title', 'Play looping video' );

          // pause video
          $( this ).addClass( 'is-paused' );
          video.addClass( 'is-paused' );
          video[0].pause();
        }
      } );
    },

    finalize: function() {
    },
  };

  app.registerComponent( 'loop-video', COMPONENT );
} )( app );
