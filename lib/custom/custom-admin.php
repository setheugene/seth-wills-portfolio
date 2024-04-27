<?php
/**
 *
 * custom admin
 *
 */

//removes default margin of admin bar
add_action('admin_bar_init', 'remove_admin_login_header');
function remove_admin_login_header() {
  remove_action('wp_head', '_admin_bar_bump_cb');
}

/**
 * A globally available ID that we can use per session
 * on the admin side. We know it'll be unique since admin
 * requests are not cached. Example use case, appending a new id
 * when retrieving the symbol-defs file directly. The file itself
 * gets cached at the network level, but the admin request won't be cached,
 * so we know we'll always have a unique filepath per session.
 */
function get_unique_id() {
  global $unique_id;
  if ( !$unique_id ) {
    $unique_id = wp_generate_uuid4();
  }

  return $unique_id;
}

/**
 * Remove Dashboard Widgets
 */
function remove_dashboard_meta() {
  remove_action( 'welcome_panel', 'wp_welcome_panel' ); // welcome panel
  remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
  remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
  remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
  remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_activity', 'dashboard', 'normal'); // since 3.8
  remove_meta_box( 'rg_forms_dashboard', 'dashboard', 'normal' ); // gravity forms
  remove_meta_box( 'tribe_dashboard_widget', 'dashboard', 'normal' ); // modern tribe events calendar
  remove_meta_box( 'mandrill_widget', 'dashboard', 'normal' ); // mandrill
  remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'normal' ); // yoast seo
  remove_meta_box( 'wpe_dify_news_feed', 'dashboard', 'normal' ); // wp engine
}
add_action( 'admin_init', 'remove_dashboard_meta' );

/* Make gravity forms available to Editor role */
function gravity_forms_access_capability() {
  $role = get_role( 'editor' ) ?? false;

  if ( $role && ! $role->has_cap( 'gform_full_access' ) ) {
    $role->add_cap( 'gform_full_access' );
  }
}
add_action( 'admin_init', 'gravity_forms_access_capability' );

/**** Dashboard Help Widget ****/

add_action('wp_dashboard_setup', 'dashboard_widgets');

function dashboard_widgets() {
  global $wp_meta_boxes;
  add_meta_box('id', 'Support', 'dashboard', 'normal', 'high');
}

add_action( 'in_admin_header','in_admin_header' );
function in_admin_header() {
  include_once( get_stylesheet_directory() . '/assets/img/symbol-defs.svg' );
}


/**
 * Set custom logo for the Wordpress login page
 */
function custom_login_logo() {

  $logo = get_field( 'global_logo', 'option' );

  if ( $logo ) : ?>
    <style type="text/css">
      #login h1 a, .login h1 a {
        background-image: url(<?php echo $logo['url']; ?> );
        width: 100%;
        height: auto;
        min-height: 100px;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center center;
      }
    </style>
  <?php endif; ?>
<?php }
add_action( 'login_enqueue_scripts', 'custom_login_logo' );

function custom_login_logo_url() {
  return home_url();
}
add_filter( 'login_headerurl', 'custom_login_logo_url' );

function custom_login_logo_url_title() {
  return get_bloginfo( 'description' );
}
add_filter( 'login_headertitle', 'custom_login_logo_url_title' );

/**
* stop_reordering_my_categories
* -----------------------------------------------------------------------------
* Keep categories and taxonomies in their hierarchical order rather than showing the selected terms on top.
*
*/
function stop_reordering_my_categories($args) {
  $args['checked_ontop'] = false;
  return $args;
}
add_filter('wp_terms_checklist_args','stop_reordering_my_categories');

function change_site_visibility() {

  if ( function_exists( 'get_field' ) ) {

    $environment = get_field('global_environment', 'option');

    if ($environment == 'development') {
      update_option('blog_public', '0');
    } else {
      update_option('blog_public', '1');
    }
  }
}
add_action('admin_init', 'change_site_visibility');

//enqueue our admin javascript/styles
function admin_enqueue_scripts() {
  $screen = get_current_screen();
  wp_enqueue_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.5.0/css/all.css', '', '5.5.0', 'all' );
  wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap', false );

  $mix_manifest = get_template_directory() . '/assets/mix-manifest.json';
  $get_assets   = file_get_contents($mix_manifest);
  $assets       = json_decode($get_assets, true);
  if (
    file_exists( $mix_manifest )
    && !empty( $assets['/css/admin.min.css'] )
    && !empty( $assets['/js/admin.min.js'] )
  ){
    wp_enqueue_style( 'admin-css', get_template_directory_uri() . '/assets' . $assets['/css/admin.min.css'] );
    wp_enqueue_script( 'admin-js', get_template_directory_uri() . '/assets'. $assets['/js/admin.min.js'], 'jquery', '', true );
  } else {
    wp_enqueue_style( 'admin-css', get_template_directory_uri() . '/assets/css/admin.min.css' );
    wp_enqueue_script( 'admin-js', get_template_directory_uri() . '/assets/js/admin.min.js', 'jquery', '', true );
  }
}
add_action('admin_enqueue_scripts', 'admin_enqueue_scripts');

/**** Custom ACF Field Utilites ****/

/*
 * Generates an array of sanitized ids from the definitions in symbol-defs.svg.
 * @params $file defaults to symbol-defs.svg, can be changed for functional use in other situtations
 */
function get_icon_list( $file='symbol-defs.svg' ) {
  $version = get_unique_id();
  $file_path = get_template_directory_uri() . "/assets/img/$file?version=$version";
  $icon_data = simplexml_load_string( file_get_contents( $file_path,false, stream_context_create( array("ssl"=>array("verify_peer"=>false,"verify_peer_name"=>false))) ) );

  if ( $icon_data ) {
    $icon_list = $icon_data->defs;
    if ( $icon_list ) {
      $icon_list = (array) $icon_list;
      if ( is_object( $icon_list['symbol'] ) ) {
        $icon_list['symbol'] = [$icon_list['symbol']];
      }
    }
  }

  $icons = array();
  if ( $icon_list ) {
    foreach( $icon_list['symbol'] as $icon_key => $icon ) {
      if ( isset( $icon['id'] ) ) {
        $icons[] = (string) substr($icon['id'], 5);
      }
    }
  }
  sort($icons);
  return $icons;
}

// Populate select with available gravity forms, shows form name, outputs form id
// Usage: Field Type: Select, Field Name containing "form_id"
add_filter('acf/load_field/type=select', 'gravity_form_type_select', 99);
function gravity_form_type_select($field) {
  global $post;
  if ( !is_admin() || !class_exists( 'RGFormsModel' ) ) {
    return $field;
  }

  if ( strpos( $field['name'], 'form_id' ) !== false ) {

    //empty out choices just in case
    $field['choices'] = array();

    $forms = RGFormsModel::get_forms( null, 'title' );

    if ( $forms ) {
      foreach ($forms as $key => $form) {
        $field['choices'][$form->id] = $form->title;
      };
    }

  }
  return $field;
}

// Output visual icon selector
// Usage: Field Name: my_component_name, Field Type: clone, Prefix Field Names: yes
// Call my_component_name_svg_icon
/*
 * Populate ACF Button Group field with symbol-defs.svg
 */
add_filter('acf/load_field/type=button_group', 'icon_picker', 99);
function icon_picker($field) {
  global $post;
  if ( !is_admin() || !function_exists('get_icon_list') ) {
    return $field;
  }

  if ( strpos( $field['name'], 'svg_icon' ) !== false ) {

    //empty out choices just in case
    $field['choices'] = array();

    $icons = get_icon_list();

    if ( $icons ) {
      foreach ($icons as $key => $icon) {
        $field['choices'][$icon] = '<svg class="icon icon-'.$icon.'" aria-hidden="true"><use xlink:href="#icon-'.$icon.'"></use></svg>';
      };
    }
  }
  return $field;
}

add_filter( 'acf/fields/flexible_content/layout_title', function($title, $field, $layout, $i) {
  return $title . ' <span class="hidden component-key" data-key="'.sanitize_title( $title ).'"></span>';
}, 99, 4 );

/**** Media Utilities ****/
/*
 * Wrap images in a figure tag
 */
function html5_insert_image($html, $id, $caption, $title, $align, $url, $size, $alt ) {
  //Always return an image with a <figure> tag, regardless of link or caption

  //Grab the image tag
  $image_tag = get_image_tag($id, $alt, $title, $align, $size);

  //Let's see if this contains a link
  $linkptrn = "/<a[^>]*>/";
  $found = preg_match($linkptrn, $html, $a_elem);

  // If no link, do nothing
  if($found > 0) {
    $a_elem = $a_elem[0];
  } else {
    $a_elem = "";
  }

  // Set up the attributes for the caption <figure>
  $attributes  = (!empty($id) ? ' id="attachment_' . esc_attr($id) . '"' : '' );
  $attributes .= ' class="thumbnail wp-caption' . 'align'.esc_attr($align) . '"';

  $output  = '<figure' . $attributes .'>';

  //add the image back in
  $output .= $a_elem;
  $output .= $image_tag;

  if($a_elem != "") {
    $output .= '</a>';
  }

  if ($caption) {
    $output .= '<figcaption class="caption wp-caption-text">'.$caption.'</figcaption>';
  }
  $output .= '</figure>';

  return $output;
}

add_filter('image_send_to_editor', 'html5_insert_image', 10, 9);
add_filter( 'disable_captions', '__return_true' );

/*
 * Change WordPress default gallery output
 * http://wpsites.org/?p=10510/
 * Used when using the Create gallery action in the wysiwyg Add Media popup
 * Also used when the media gallery shortcode is used as well
 */
add_filter('post_gallery', 'gallery_output', 10, 2);
function gallery_output($output, $attr) {
  global $post;
  if (isset($attr['orderby'])) {
      $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
      if (!$attr['orderby'])
          unset($attr['orderby']);
  }

  extract(shortcode_atts(array(
      'order' => 'ASC',
      'orderby' => 'menu_order ID',
      'id' => $post->ID,
      'itemtag' => 'dl',
      'icontag' => 'dt',
      'captiontag' => 'dd',
      'columns' => 3,
      'size' => 'thumbnail',
      'include' => '',
      'exclude' => ''
  ), $attr));

  $id = intval($id);
  if ('RAND' == $order) $orderby = 'none';

  if (!empty($include)) {
      $include = preg_replace('/[^0-9,]+/', '', $include);
      $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

      $attachments = array();
      foreach ($_attachments as $key => $val) {
          $attachments[$val->ID] = $_attachments[$key];
      }
  }

  if (empty($attachments)) return '';

  // Here's your actual output, you may customize it to your need
  $output = "<div class=\"gallery\">\n";

  // Now you loop through each attachment
  foreach ($attachments as $id => $attachment) {
      // Fetch all data related to attachment
      $img = wp_prepare_attachment_for_js($id);

      // If you want a different size change 'large' to eg. 'medium'
      $popup = $img['sizes']['full']['url'];
      $url = $img['sizes']['medium']['url'];
      $height = $img['sizes']['medium']['height'];
      $width = $img['sizes']['medium']['width'];
      $alt = $img['alt'];

      // Store the caption
      $caption = $img['caption'];

      $output .= "<figure class=\"gallery-item\">\n";
      $output .= "<a class=\"gallery-item-popup\" href=\"{$popup}\">\n";
      $output .= "<img src=\"{$url}\" width=\"{$width}\" height=\"{$height}\" alt=\"{$alt}\" />\n";
      $output .= "</a>\n";
      $output .= "</figure>\n";
  }

  $output .= "</div>\n";
  return $output;
}

/*
 * Allow SVGs to be uploaded to Media Library
 * upload_mimes filter allows the file picker to actually allow
 * files with the extension of svg. It also allows svgs without
 * a xml declaration to be uploaded.
 *
 * The floowing allow_custom_mimes function is what allows us to also allow
 * svgs with the xml declaration to get uploaded since we need both.
 */
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

function allow_custom_mimes($check, $file, $filename) {
  $mimeTypes = [
    [ 'svg' => 'image/svg+xml' ],
  ];
  if ( empty($check['ext']) && empty($check['type'])) {
    foreach( $mimeTypes as $mime ) {
      remove_filter( 'wp_check_filetype_and_ext', 'allow_custom_mimes', 99 );
      $filtered_mimes = function($mimes) use ($mime) {
        return array_merge($mimes, $mime);
      };
      add_filter('upload_mimes', $filtered_mimes, 99);
      $check = wp_check_filetype_and_ext( $file, $filename, $mime );
      remove_filter('upload_mimes', $filtered_mimes, 99);
      add_filter( 'wp_check_filetype_and_ext', 'allow_custom_mimes', 99, 3 );
      if ( ! empty( $check['ext'] ) || ! empty( $check['type'] ) ) {
        return $check;
      }
    }
  }
  return $check;
}
add_filter( 'wp_check_filetype_and_ext', 'allow_custom_mimes', 99, 3 );

/*
 * Set max upload size for image types
 */
function max_image_size_check( $file ) {
  $size = $file['size'];
  $size = $size / 1024;
  $type = $file['type'];
  $is_image = strpos( $type, 'image' ) !== false;
  $limit = 1000;
  $limit_output = '1000kb';
  $max_size = 2000;
  $img_sizes = getimagesize($file['tmp_name']);

  if ( $is_image && $img_sizes ) {

    if ( $size > $limit ) {
      $file['error'] = 'Image files must be smaller than ' . $limit_output;
    }

    if ( $img_sizes[0] > $max_size || $img_sizes[1] > $max_size ) {
      $file['error'] = 'Image can not be wider or taller than ' . $max_size .'px';
    }
  }

  return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'max_image_size_check' );

/* Allow svg and other associated tags and attributes
 * so our svg icon selector displays properly
*/
add_filter( 'wp_kses_allowed_html', 'acf_add_allowed_svg_tag', 10, 2 );
function acf_add_allowed_svg_tag( $tags, $context ) {
    if ( $context === 'acf' ) {
        $tags['svg']  = array(
            'xmlns'       => true,
            'fill'        => true,
            'viewbox'     => true,
            'role'        => true,
            'aria-hidden' => true,
            'focusable'   => true,
            'class' => true,
        );
        $tags['path'] = array(
            'd'    => true,
            'fill' => true,
        );
        $tags['use'] = array(
          'xlink:href' => true,
        );
    }

    return $tags;
}

/*
 * Sort ACF field groups alphabetically
 */
function sort_acf_field_groups( $wp_query ) {
  global $pagenow;
  if ( isset( $_GET['post_type'] ) && is_admin() && $_GET['post_type'] == 'acf-field-group' && 'edit.php' == $pagenow && !isset( $_GET['orderby'] ) ) {
    $wp_query->set( 'orderby', 'title' );
    $wp_query->set( 'order', 'ASC' );
  }
}
add_filter('pre_get_posts', 'sort_acf_field_groups' );


if ( !function_exists( 'lll' ) ) {
  function lll() {
    if ( current_user_can( 'administrator' ) ) {
      ?>
      <script>
        console.log( 'Undefined function lll() found.' );
      </script>
      <?php
    }
  }
}

// add new field to acf field group
add_action('acf/render_field_group_settings', 'acf_option_add_to_components');
function acf_option_add_to_components($field_group){
    acf_render_field_wrap(array(
        'label'			=> __('Add to Components Flexible Content','acf'),
        'type'			=> 'true_false',
        'name'			=> 'add_to_components',
        'prefix'		=> 'acf_field_group',
        'value'			=> ( isset($field_group['add_to_components']) ) ? $field_group['add_to_components'] : '',
    ));
}

function compare_by_component_label($a, $b) {
  return strcmp($a['label'], $b['label']);
}

/**
 * Automatically add components to Components field group, and order it alphabetically
 */
add_action('acf/update_field_group', function( $field_group ) {
  if ( !empty( $field_group['add_to_components'] ) ) {
    $acf_components_field = 'field_5d0d37adc1475';
    $field = acf_get_field( $acf_components_field );

    if ( !$field ) {
      var_error_log( 'Components field not found' );
      return null;
    }
    $layouts = $field['layouts'];

    /* get saved field group stuff */
    /* convert the slug to an underscored name, using the component filename field if necessary */
    $field_group_slug = get_field( 'component_filename', $field_group['ID'] ) ?: str_replace( 'Component : ', '', $field_group['title'] );
    $field_group_slug = str_replace('-', '_', sanitize_title($field_group_slug));

    /* Check if the component has already been added to the flexible layout */
    $search = acf_search_fields( $field_group_slug, $layouts );

    $new_field = false;

    if ( !$search ) {
      $new_field = true;
    }

    if ( $new_field ) {
      /* Create new layout in flexible content */
      $layout_key = 'layout_'.uniqid();
      $layouts[$layout_key] = [
        'key' => $layout_key,
        'label' => str_replace( 'Component : ', '', $field_group['title'] ),
        'name' => $field_group_slug,
        'display' => 'block',
        'sub_fields' => [
        ]
      ];

      /* sort the layouts alphabetically */
      usort($layouts, 'compare_by_component_label');

      $field['layouts'] = $layouts;

      acf_update_field( $field );

      /* Add meta clone to new layout */
      $meta_args = array(
        'key' => 'field_' . uniqid(),
        'label' => 'Meta',
        'name' => 'meta',
        'type' => 'clone',
        'clone' => array(
          0 => 'group_5d0d37eae4bed',
        ),
        'parent' => $field['ID'],
        'parent_layout' => $layout_key
      );

      acf_update_field($meta_args);

      /* Add new component field group clone to layout */
      $field_args = array(
        'key' => 'field_'.uniqid(),
        'label' => str_replace( 'Component : ', '', $field_group['title'] ) . ' Fields',
        'name' => 'fields',
        'type' => 'clone',
        'clone' => array(
          0 => $field_group['key'],
        ),
        'parent' => $field['ID'],
        'parent_layout' => $layout_key
      );

      acf_update_field($field_args);

      /* Save the updated field group to local json */
      $components_field_group = 'group_5d0d37a81ca8d';
      $component_group = acf_get_field_group( $components_field_group );

      if ( $component_group ) {
        $json = new ACF_Local_JSON;
        $json->update_field_group( $component_group );
      } else {
        var_error_log( 'Components custom field group not found' );
      }
    }
  }
}, 10, 1);
