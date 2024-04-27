<?php
global $post;
$component_page_id = match( true ) {
  !empty($args['page_for_components_id']) => $args['page_for_components_id'],
  isset($post_id) => $post_id,
  default => $post->ID,
};

/*
 * Set up components if there is only one component on the page
 */
if ( !have_rows( 'components', $component_page_id ) ) { // if it is not the components page
  $component_fields = [];
  $components_fc_exists = false;
  if ( !isset($component_slug) ) {
    $component_slug = '';
  }

  if ( acf_get_field_groups(array('post_id' => $component_page_id)) ) {
    foreach ( acf_get_field_groups(array('post_id' => $component_page_id)) as $key => $group ) {
      $fields = acf_get_fields($group['key']);
      if ( $fields[0]['label'] == 'Components' ) {
        $components_fc_exists = true;
      }
    }
  }
  $group_key = acf_get_field_groups(array('post_id' => $component_page_id))[0]['key'];
  if ( acf_get_fields($group_key)[0]['label'] == 'Components' || $components_fc_exists ) {
    return;
  }
  foreach ( acf_get_fields($group_key) as $key => $field ) {
    $component_fields[$field['name']] = get_field( $field['name'], $component_page_id );
  }
  $layout = str_replace('-', '_', $component_slug ?: get_post($component_page_id)->post_name);
  $components[0] = $component_fields;
  $components[0]['acf_fc_layout'] = $layout;
} else { // if it is the components page
  $components = get_field('components', $component_page_id);
}

/*
 * if you want to hardcode in components instead of autogenerating them,
 * include them in this list, and hardcode the fields in the else statement below
 */
$hardcode_components = [
  // 'hero_banner'
];
?>

<?php if ( have_rows( 'components', $component_page_id ) || $components ) : ?>

  <?php
    foreach ($components as $key => $component) {
      $component_slug = str_replace('_', '-', $component['acf_fc_layout']);
      $index = $key;
      $next_index = $key + 1;
      $previous_index = $key - 1;
      $next_target = sanitize_title( $components[$key + 1]['target_name'] ?? '' );
      $previous_component = $components[$previous_index]['acf_fc_layout'] ?? '';
      $next_component     = $components[$next_index]['acf_fc_layout'] ?? '';
      $classes = [];
      // Add classes to components
      switch( $component_slug ) {
        // case 'hero-banner' :
        //   $classes = ['bg-black text-white'];
        //   break;
      }

      if ( !$next_target ) {
        $next_target = 'component-' . ( $key + 1 );
      }
      if ( !in_array( $component['acf_fc_layout'], $hardcode_components ) ) {
        /*
         * Make sure format_component_data() is in the theme.
         * Your field name must match the parameter you pass to your component,
         * with the component name as the prefix. For example:
         * 'content' = $component['hero_banner_content']
         * If they cannot match for whatever reason, hardcode the field names for
         * the component.
         */
        include_component(
          str_replace('_', '-', $component['acf_fc_layout']), // component name (converted to kebab case)
          format_component_data($component['acf_fc_layout'], $component), // pass in the ACF fields
          ['classes' => $classes, 'id' => !empty( $component['target_name'] ) ? sanitize_title($component['target_name']) : "component-{$key}"] // set the ID
        );
        } else {
        switch ( $component['acf_fc_layout'] ) {
          // case 'hero_banner' :
          //   include_component(
          //     'hero-banner',
          //     array(
          //       'content'         => $component[ 'hero_banner_content'],
          //       'next_component' => ( $components[$next_index] ? $next_target : '' )
          //     ),
          //     array(
          //       'id' => sanitize_title($component['target_name']) ?: "component-{$key}"
          //     )
          //   );
          //   break;
        }
      }
    }
  ?>

<?php endif; ?>
