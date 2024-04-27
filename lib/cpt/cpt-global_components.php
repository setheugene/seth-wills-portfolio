<?php
if ( ! function_exists('register_global_component_custom_post_type') ) {
  function register_global_component_custom_post_type() {
    $labels = array(
      'name'                => 'Global Components',
      'singular_name'       => 'Global Component',
      'menu_name'           => 'Global Components',
      'parent_item_colon'   => 'Parent Global Component',
      'all_items'           => 'All Global Components',
      'view_item'           => 'View Global Component',
      'add_new_item'        => 'Add New Global Component',
      'add_new'             => 'New Global Component',
      'edit_item'           => 'Edit Global Component',
      'update_item'         => 'Update Global Component',
      'search_items'        => 'Search Global Components',
      'not_found'           => 'No Global Components found',
      'not_found_in_trash'  => 'No Global Components found in Trash',
    );
    $args = array(
      'label'               => 'Global Component',
      'description'         => 'Global Component description',
      'labels'              => $labels,
      'supports'            => array( 'title' ),
      'hierarchical'        => false,
      'public'              => false,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_nav_menus'   => false,
      'show_in_admin_bar'   => false,
      'menu_position'       => 2,
      'menu_icon'           => 'dashicons-layout',
      'can_export'          => true,
      'has_archive'         => false,
      'exclude_from_search' => true,
      'publicly_queryable'  => false,
      'capability_type'     => 'post',
    );
    register_post_type( 'global_component', $args );

  }
  add_action( 'init', 'register_global_component_custom_post_type', 0 );
}

