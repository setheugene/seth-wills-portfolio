<?php
/**
 *
 * Custom utilities
 * Utilities, filters, etc.
 *
 */

/**
* generate_schema_json
* -----------------------------------------------------------------------------
*
*/
function generate_schema_json() {
  $schema = array(
    '@context'  => 'http://schema.org',
    '@type'     => get_field('schema_type', 'option'),
    'name'      => get_bloginfo('name'),
    'url'       => get_home_url(),
    'telephone' => strip_phone( get_field('contact_phone_number', 'option') ),
    'email' => get_field('contact_email_address', 'option'),
    'address'   => array(
      '@type'           => 'PostalAddress',
      'streetAddress'   => get_field('contact_street_address', 'option'),
      'postalCode'      => get_field('contact_zip', 'option'),
      'addressLocality' => get_field('contact_city', 'option'),
      'addressRegion'   => get_field('contact_state', 'option'),
      'addressCountry'  => get_field('contact_country', 'option')
    )
  );
  /// LOGO
  if (get_field('schema_logo', 'option')) {
    $schema['logo'] = get_field('schema_logo', 'option');
  }
  /// IMAGE
  if (get_field('schema_building_photo', 'option')) {
    $schema['image'] = get_field('schema_building_photo', 'option');
  }
  /// SOCIAL MEDIA
  // Google only looks for these social media sites
  // https://ignitevisibility.com/how-to-specify-your-social-media-profiles-so-they-show-in-google/
  $social_media_sites = array(
    'facebook' => get_field( 'social_facebook', 'option' ),
    'twitter' => get_field( 'social_twitter', 'option' ),
    'instagram' => get_field( 'social_instagram', 'option' ),
    'youtube' => get_field( 'social_youtube', 'option' ),
    'linkedin' => get_field( 'social_linkedin', 'option' ),
    'pinterest' => get_field( 'social_pinterest', 'option' ),
  );

  if ( filter_array( $social_media_sites ) ) {
    $schema['sameAs'] = array();
    foreach ( $social_media_sites as $key => $social_media ) {
      if ( $social_media ) {
        array_push( $schema['sameAs'], $social_media );
      }
    }
  }
  /// OPENING HOURS
  if (have_rows('schema_openings', 'option')) {
    $schema['openingHoursSpecification'] = array();
    while (have_rows('schema_openings', 'option')) : the_row();
    $closed = get_sub_field('closed');
    $from   = $closed ? '00:00' : get_sub_field('from');
    $to     = $closed ? '00:00' : get_sub_field('to');
    $openings = array(
      '@type'     => 'OpeningHoursSpecification',
      'dayOfWeek' => get_sub_field('days'),
      'opens'     => $from,
      'closes'    => $to
      );
    array_push($schema['openingHoursSpecification'], $openings);
    endwhile;
    /// VACATIONS / HOLIDAYS
    if (have_rows('schema_special_days', 'option')) {
      while (have_rows('schema_special_days', 'option')) : the_row();
      $closed    = get_sub_field('closed');
      $date_from = get_sub_field('date_from');
      $date_to   = get_sub_field('date_to');
      $time_from = $closed ? '00:00' : get_sub_field('time_from');
      $time_to   = $closed ? '00:00' : get_sub_field('time_to');
      $special_days = array(
        '@type'        => 'OpeningHoursSpecification',
        'validFrom'    => $date_from,
        'validThrough' => $date_to,
        'opens'        => $time_from,
        'closes'       => $time_to
        );
      array_push($schema['openingHoursSpecification'], $special_days);
      endwhile;
    }
  }
  echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';
}
add_action( 'wp_head', 'generate_schema_json'  );




/**
 * Remove version info from head and feeds
 * Keeps bots from targetting specific versions of wordpress with this meta
 */
function remove_wp_version() {
  return '';
}
add_filter('the_generator', 'remove_wp_version');

/**
 * * Remove Emoji styles/scripts that were Introduced In WordPress 4.2
 * * Comment out function to enable them
 */
function ll_remove_wp_emoji()  {
  // Remove from comment feed and RSS
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // Remove from emails
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

  // Remove from head tag
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );

  // Remove from print related styling
  remove_action( 'wp_print_styles', 'print_emoji_styles' );

  // Remove from admin area
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'll_remove_wp_emoji' );

/**
 * Add wistia (video host) to whitelist of available oembed providers
 */
wp_oembed_add_provider( '/https?:\/\/(.+)?(wistia.com|wi.st)\/(medias|embed)\/.*/', 'http://fast.wistia.com/oembed', true);


/**
 * Custom wp_parse_args function
 * - Allows for recursive parsing
 *
 * @param  array $a arguments array
 * i.e:
 * array(
 *   'example' => 'foo',
 *   'example-array' => array(
 *     'nested' => 'bar'
 *   )
 * )
 *
 * @param  array $b default value array i.e array( 'example' => null )
 * i.e:
 * array(
 *   'example' => null,
 *   'example-array' => array(
 *     'nested' => null
 *   )
 * )
 *
 * @return array
 */
function parse_args( &$a, $b ) {
  $a = (array) $a;
  $b = (array) $b;
  $result = $b;

  foreach ( $a as $k => &$v ) {

    if ( $v || (is_bool($v) && !$v) ) {
      if ( is_array( $v ) && isset( $result[ $k ] ) ) {
        $result[ $k ] = parse_args( $v, $result[ $k ] );
      } else {
        $result[ $k ] = $v;
      }
    } else {
      if ( !isset( $result[ $k ] ) ) {
        $result[ $k ] = null;
      }
    }
  }

  return $result;
}

/**
 * Takes in a multideminsional array and removes null values recursively
 *
 * @param  [array]
 * @return [array]
 */
function filter_array( $component_data ) {

  foreach ( $component_data as $key => $value ) {
    if ( is_array( $value ) ) {
      $component_data[$key] = filter_array( $component_data[$key] );
    }

    if ( empty( $component_data[$key] ) ) {
      unset( $component_data[$key] );
    }
  }

  return $component_data;
}


/**
 * Checks if an array is empty after recursively removing null values
 *
 * @param  [array]
 * @return [boolean]
 */
function is_empty( $array ) {

  $filter = filter_array( $array );

  if( empty( $filter ) ) {
    return  true;
  }

  else {
    return false;
  }
}

function ll_get_the_slug( $id=null ){
  if( empty($id) ):
    global $post;
    if( empty($post) )
      return ''; // No global $post var available.
    $id = $post->ID;
  endif;

  $slug = basename( get_permalink($id) );
  return $slug;
}

/**
 * Emulates var_dump into the log file.
 * Useful for var_dumping AJAX calls
 */
function var_error_log( $object=null ){
  ob_start();
  $object = json_encode($object);
  echo $object;
  $contents = ob_get_contents();
  ob_end_clean();
  error_log( $contents );
}

/**
 * Escape JSON for use on HTML or attribute text nodes.
 * Taken from Woocommerce, wc_esc_json
 * @since 3.5.5
 * @param string $json JSON to escape.
 * @param bool   $html True if escaping for HTML text node, false for attributes. Determines how quotes are handled.
 * @return string Escaped JSON.
 */
function esc_json( $json, $html = false ) {
  return _wp_specialchars(
    $json,
    $html ? ENT_NOQUOTES : ENT_QUOTES, // Escape quotes in attribute nodes only.
    'UTF-8',                           // json_encode() outputs UTF-8 (really just ASCII), not the blog's charset.
    true                               // Double escape entities: `&amp;` -> `&amp;amp;`.
  );
}

function is_element_empty($element) {
  $element = trim($element);
  return !empty($element);
}

/**
 * Quick function to return syntax for symbol-def icons
 */
function ll_icon( $icon_name, $classes = '' ) {
  return '<svg class="icon icon-' . $icon_name . ' ' . $classes . '"><use xlink:href="#icon-' . $icon_name . '"></use></svg>';
}
