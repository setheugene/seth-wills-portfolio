<?php


add_action('init', function() {
  $router = new Router('theme_router');
  $routes = array(
    'component_preview' => Route::default( 'component-preview', '', get_stylesheet_directory() . '/templates/component-preview.php' )
  );

  RouteProcessor::init( $router, $routes );
}, 0 );
