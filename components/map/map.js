/**
* map JS
* -----------------------------------------------------------------------------
*
* All the JS for the map component.
*/

// VARS that are set in map.php:
// mapLocations - array of objects [{address, city, state, zip, coordinates: {lat, lng}}]
// mapStyle - url string of mapbox studio style link
// mapKey - string of mapbox api key
// map icon can be setup in the map.css .markers class and can be an svg or png or custom text. Sky's the limit. You do more with the .markers element in the addMarkers() function
( function( app ) {
  const COMPONENT = {

    className: 'map',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
      // function to allow .remove() to work for removing open popups in createPopup()
      if ( !( 'remove' in Element.prototype ) ) {
        Element.prototype.remove = function() {
          if ( this.parentNode ) {
            this.parentNode.removeChild( this );
          }
        };
      }
      // mapKey variable is set in the PHP file
      mapboxgl.accessToken = llMapbox.token;

      $( '.map' ).each( function() {
        const mapLocations = $( this ).data( 'locations' );
        // unique id to render map in
        const mapId = 'map-' + $( this ).attr( 'id' );

        if ( mapLocations ) {
          // Initialize the map
          loadMap( mapLocations, mapId );
        }
      } );

      function loadMap( mapLocations, mapId ) {
        const places = [];
        let bounds;

        if ( mapLocations.length > 1 ) {
          bounds = new mapboxgl.LngLatBounds();
        }

        mapLocations.forEach( ( loc, index ) => {
          const place = {
            type: 'Feature',
            properties: {
              id: index,
              description:
              `<address class="p-2 text-xs not-italic text-center">
                <span class="block">${loc.address.street}</span>
                <span>${loc.address.street_2}</span>
                <span class="block">${loc.address.city}, ${loc.address.state} ${loc.address.zip}</span>
              </address>
              <span class="block mb-2 text-center">${loc.phone}</span>
              <a class="block p-2 leading-normal text-center text-white bg-black rounded-br rounded-bl" href="https://www.google.com/maps/place/${loc.address.street}+${loc.address.city}+${loc.address.state}" target="_blank">Get Directions</a>`,
            },
            geometry: {
              type: 'Point',
              coordinates: [parseFloat( loc.coordinates.long ), parseFloat( loc.coordinates.lat )],
            },
          };

          places.push( place );

          if ( mapLocations.length > 1 ) {
            bounds.extend( place.geometry.coordinates );
          }
        } );

        let center;
        if ( mapLocations.length === 1 ) {
          center = places[0].geometry.coordinates;
        } else {
          center = bounds.getCenter();
        }

        const map = new mapboxgl.Map( {
          container: mapId, // mounts on the elements current id
          style: llMapbox.style, // stylesheet URL set in PHP file
          center: center,
          zoom: 10,
        } );


        // if there are multiple locations will make sure
        // all locations are visible on load
        // padding can be increased or decreased to make sure
        // there is more space between the furthest markers and the edge of the map
        if ( mapLocations.length > 1 ) {
          map.fitBounds( bounds, {padding: 80} );
        }

        // add locations from the places array to the map
        // and create the markers
        // and add the map navigations controls
        map.on( 'load', () => {
          // add this "geojson" object to the map, passing in the places array
          map.addSource( 'points', {
            type: 'geojson',
            data: {
              type: 'FeatureCollection',
              features: places,
            },
          } );

          addMarkers( places, map );

          map.addControl( new mapboxgl.NavigationControl() );
        } );
      }

      function addMarkers( locations, map ) {
        locations.forEach( function( marker, i ) {
          const el = document.createElement( 'div' );
          /* Assign a unique `id` to the marker. */
          el.id = 'marker-' + marker.properties.id;
          /* Assign the `marker` class to each marker for styling. */
          el.className = 'marker';
          // you can add you svg here through js or set is as background image or whichever you prefer. Anything can be used as a marker in this situation.

          /**
           * Create a marker using the div element
           * defined above and add it to the map.
           **/
          new mapboxgl.Marker( el, {offset: [0, -23]} )
              .setLngLat( marker.geometry.coordinates )
              .addTo( map );

          /* Add a click event to marker to open the location popup */
          el.addEventListener( 'click', function( e ) {
            createPopUp( marker, map );
            e.stopPropagation();
          } );
        } );
      }

      function createPopUp( currentLocation, map ) {
        const popUps = document.getElementsByClassName( 'mapboxgl-popup' );
        // remove popups if any are open
        if ( popUps[0] ) popUps[0].remove();

        new mapboxgl.Popup( {offset: {'bottom': [0, -49]}} )
            .setLngLat( currentLocation.geometry.coordinates )
            .setHTML( currentLocation.properties.description )
            .addTo( map );
      }
    },
    finalize: function() {
    },
  };

  // Hooks the component into the app
  app.registerComponent( 'map', COMPONENT );
} )( app );
