<?php
  get_template_part('templates/partials/head');
?>
<body <?php body_class(); ?> data-component="animations">
  <?php include_once( 'assets/img/symbol-defs.svg' ); ?>
  <?php include_once( 'assets/img/symbol-defs-ui.svg' ); ?>
  <!--[if lt IE 8]>
  <div class="alert alert-warning">
  <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
  </div>
  <![endif]-->

  <?php
    do_action('get_header');
    get_template_part('templates/partials/header');
  ?>

  <div class="wrap" role="document">
    <main class="main" role="main">
      <?php if ( post_password_required() ) : ?>
        <?php get_template_part('templates/partials/password-form'); ?>
      <?php else : ?>
        <?php include roots_template_path(); ?>
      <?php endif; ?>
    </main><!-- /.main -->
  </div><!-- /.wrap -->

  <?php get_template_part('templates/partials/footer'); ?>

  <?php wp_footer(); ?>
</body>
</html>
