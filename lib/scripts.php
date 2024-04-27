<?php
/**
 * Scripts and stylesheets
 *
 * Enqueue stylesheets in the following order:
 * 1. /theme/assets/css/main.css
 *
 * Enqueue scripts in the following order:
 * 1. jquery-3.6.0.min.js via Google CDN
 * 2. /theme/assets/js/vendor/modernizr.min.js
 * 3. /theme/assets/js/scripts.js (in footer)
 *
 * Google Analytics is loaded after enqueued scripts if:
 * - An ID has been defined in config.php
 * - You're not logged in as an administrator
 */
function reset_scripts() {
  $assets = assets();

  wp_enqueue_style('roots_reset_css', get_template_directory_uri() . $assets['reset'], false, null);
}
add_action('wp_enqueue_scripts', 'reset_scripts', 1);


function roots_scripts() {

  $street_address = get_field( 'contact_street_address', 'option' );
  $city = get_field( 'contact_city', 'option' );
  $state = get_field( 'contact_state', 'option' );
  $zip = get_field( 'contact_zip', 'option' );
  $coords = get_field( 'location_coords', 'option' );

  /**
   * The build task in Grunt renames production assets with a hash
   * Read the asset names from assets-manifest.json
   */
  $assets = assets();

  wp_enqueue_style('roots_css', get_template_directory_uri() . $assets['css'], ['roots_reset_css'], null);

  /**
   * jQuery is loaded using the same method from HTML5 Boilerplate:
   * Grab Google CDN's latest jQuery with a protocol relative URL;
   * It's kept in the header instead of footer to avoid conflicts with plugins.
   */
  if (!is_admin() && current_theme_supports('jquery-cdn')) {
    wp_deregister_script('jquery');
    wp_register_script('jquery', $assets['jquery'], array(), null, false);
  }

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  if ( get_field( 'components' ) || (isset($_GET['component']) && $_GET['component'] == 'map') ) {
    $components = get_field( 'components' ) ?? array();
    $components = array_filter( $components, function( $component ) {
      return $component['acf_fc_layout'] == 'map';
    } );

    if ( !empty( $components ) || ((isset($_GET['component']) && $_GET['component'] == 'map')) ) {
      wp_enqueue_script( 'mapbox', 'https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js' );
      wp_enqueue_style( 'mapbox', 'https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css' );
      wp_localize_script( 'mapbox', 'llMapbox', array(
        'token' => get_field( 'global_mapbox_token', 'option' ),
        'style' => get_field( 'global_mapbox_style', 'option' ),
        'pin'   => get_stylesheet_directory_uri() . '/assets/img/map-pin.png',
      ) );
    }
  }

  wp_enqueue_script('jquery');
  wp_enqueue_script('vendor_js', get_template_directory_uri() . $assets['vendor'], array(), null, true);
  wp_enqueue_script('roots_js', get_template_directory_uri() . $assets['js'], array(), null, true);

  wp_localize_script( 'roots_js', 'siteInfo', array(
    'url' => home_url(),
    'name' => get_bloginfo('name'),
    'address' => array(
      'street' => $street_address,
      'city' => $city,
      'state' => $state,
      'zip' => $zip,
      'coords' => $coords
    ),
    'ajax_url' => admin_url( 'admin-ajax.php' ),
    'wpApiSettings' => array(
      'root'        => esc_url_raw( rest_url() ),
      'll'          => esc_url_raw( rest_url() ) .'ll/api/v1/',
      'nonce'       => wp_create_nonce( 'wp_rest' ),
    )
  ) );

  // Remove block library css
  wp_dequeue_style( 'wp-block-library' );
  wp_dequeue_style( 'wp-block-library-theme' );
}
add_action('wp_enqueue_scripts', 'roots_scripts', 100);

add_filter( 'script_loader_tag', 'defer_scripts', 10, 3 );
function defer_scripts( $tag, $handle, $src ) {

	// The handles of the enqueued scripts we want to defer
	$defer_scripts = array(
    'admin-bar',
    'vendor_js',
    'roots_js'
	);

    if ( in_array( $handle, $defer_scripts ) ) {
      return '<script src="' . $src . '" defer type="text/javascript" id="'.$handle.'"></script>' . "\n";
    }

    return $tag;
}

function assets() {
  $mix_manifest = get_template_directory() . '/assets/mix-manifest.json';
  $get_assets   = file_get_contents($mix_manifest);
  $assets       = json_decode($get_assets, true);
  if (
    file_exists( $mix_manifest ) &&
    !empty( $assets['/css/reset.min.css'] ) &&
    !empty( $assets['/css/main.min.css'] ) &&
    !empty( $assets['/js/vendor.min.js'] ) &&
    !empty( $assets['/js/scripts.min.js'] )
  ) {
    $assets     = array(
      'reset'     => '/assets'.$assets['/css/reset.min.css'],
      'css'       => '/assets'.$assets['/css/main.min.css'],
      'vendor'    => '/assets'.$assets['/js/vendor.min.js'],
      'js'        => '/assets'.$assets['/js/scripts.min.js'],
      'jquery'    => '//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'
    );
  } else {
    $assets = array(
      'reset'     => '/assets/css/reset.min.css',
      'css'       => '/assets/css/main.min.css',
      'vendor'    => '/assets/js/vendor.min.js',
      'js'        => '/assets/js/scripts.min.js',
      'jquery'    => '//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'
    );
  }
  return $assets;
}
