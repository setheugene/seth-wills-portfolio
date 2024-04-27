---
to: lib/cpt/cpt-<%=h.changeCase.snakeCase(name)%>.php
slug: <% slug = h.changeCase.snakeCase(name) %>
plural: <% plural = h.inflection.pluralize(name) %>
---
<?php
/**
 * Register the custom post type
 */
if ( ! function_exists('register_<%= slug %>_custom_post_type') ) {

  // Register Custom Post Type
  function register_<%= slug %>_custom_post_type() {

    /*
     * Checks if you've setup a custom page to use as
     * the archive for this post type. To do that, use the
     * commented out block at the bottom to register the settings page.
     * This makes it behave like the default page_for_posts so that
     * content can change the slug to be more seo friendly.
     */
    if (class_exists('ACF')) {
      $id = get_field( 'page_for_<%= slug %>', 'option' );
    }
    $slug = '<%= slug %>';

    if ( $id ) {
      $slug = get_the_slug( $id );
    }

    $labels = array(
      'name'                => '<%= plural %>',
      'singular_name'       => '<%= name %>',
      'menu_name'           => '<%= plural %>',
      'parent_item_colon'   => 'Parent <%= name %>',
      'all_items'           => 'All <%= plural %>',
      'view_item'           => 'View <%= name %>',
      'add_new_item'        => 'Add New <%= name %>',
      'add_new'             => 'New <%= name %>',
      'edit_item'           => 'Edit <%= name %>',
      'update_item'         => 'Update <%= name %>',
      'search_items'        => 'Search <%= name %>',
      'not_found'           => 'No <%= plural %> found',
      'not_found_in_trash'  => 'No <%= plural %> found in Trash',
    );
    $args = array(
      'label'               => '<%= name %>',
      'description'         => '<%= name %> description',
      'labels'              => $labels,
      'supports'            => array( 'title', 'page-attributes', 'thumbnail' ),
      // 'taxonomies'          => array( 'category', 'post_tag' ),
      'hierarchical'        => true,
      'public'              => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_nav_menus'   => true,
      'show_in_admin_bar'   => true,
      'menu_position'       => 20,
      'menu_icon'           => 'dashicons-camera',
      'can_export'          => true,
      'has_archive'         => true,
      'exclude_from_search' => true, // false if using taxonomy pages
      'publicly_queryable'  => true,
      'capability_type'     => 'post',
      'rewrite'             => array( 'slug' => $slug )
    );
    register_post_type( '<%= slug %>', $args );

  }

  // Hook into the 'init' action
  add_action( 'init', 'register_<%= slug %>_custom_post_type', 0 );

}

/**
 * Custom taxonomies
 */
// if ( ! function_exists('register_<%= slug %>_taxonomies') ) {

//   function register_<%= slug %>_taxonomies() {

//     // Add new taxonomy, make it hierarchical (like categories)
//     $labels = array(
//       'name'                => _x( 'Category', 'taxonomy general name' ),
//       'singular_name'       => _x( 'Category', 'taxonomy singular name' ),
//       'search_items'        => __( 'Search Categories' ),
//       'all_items'           => __( 'All Categories' ),
//       'parent_item'         => __( 'Parent Category' ),
//       'parent_item_colon'   => __( 'Parent Category:' ),
//       'edit_item'           => __( 'Edit Category' ),
//       'update_item'         => __( 'Update Category' ),
//       'add_new_item'        => __( 'Add New Category' ),
//       'new_item_name'       => __( 'New Category Name' ),
//       'menu_name'           => __( 'Categories' )
//     );

//     $args = array(
//       'hierarchical'        => true,
//       'labels'              => $labels,
//       'show_ui'             => true,
//       'show_admin_column'   => true,
//       'query_var'           => true,
//       'rewrite'             => array( 'slug' => get_field( '<%= slug %>_category_slug', 'option' ) ?:  '<%= slug %>-category' )
//     );

//     register_taxonomy( '<%= slug %>_category', array( '<%= slug %>' ), $args ); // Must include custom post type name

//   }

//   add_action( 'init', 'register_<%= slug %>_taxonomies', 0 );

// }

/**
 * Create ACF setting page under CPT menu
 */

// if ( function_exists( 'acf_add_options_sub_page' ) ){
//   acf_add_options_sub_page(array(
//     'page_title' => '<%= name %> Settings',
//     'menu_title' => 'Settings',
//     'menu_slug'  => '<%= slug %>-settings',
//     'parent'     => 'edit.php?post_type=<%= slug %>',
//     'capability' => 'edit_posts'
//   ));
// }



