<?php
  global $wp;
  $attempt = str_replace(site_url('/'), '', home_url( $wp->request ));
  $attempt = str_replace('-', ' ', $attempt);

  $args = array(
    'post_type' => 'any',
    'post_status' => 'publish',
    's' => $attempt,
    'posts_per_page' => 5
  );
  $query = get_posts($args);
?>

<div class="mx-0 my-24 overflow-hidden text-center error-page">

  <div class="container">

    <h1 class="mx-auto mb-5 hdg-1">Not Found</h1>

    <div class="error__desc paragraph-large">

      <div class="alert alert-warning">

        <?php _e('Sorry, but the page you were trying to view does not exist.', 'roots'); ?>

      </div>

      <p class="mt-4"><?php _e('It looks like this was the result of either:', 'roots'); ?></p>

      <ul class="p-0 m-0">

        <li><?php _e('a mistyped address', 'roots'); ?></li>

        <li><?php _e('an out-of-date link', 'roots'); ?></li>

      </ul>

      <?php if ( $query ): ?>

        <div class="mt-8">

          <p>Were you looking for the one of the following pages?</p>

          <ul class="p-0 m-0 posts-list">

            <?php foreach ( $query as $key => $post ) : ?>

              <li class="mt-4"><a href="<?php echo get_permalink( $post->ID ); ?>" class="hover:underline"><?php echo $post->post_title; ?></a></li>

            <?php endforeach; ?>

          </ul>

        </div>

      <?php endif; ?>

    </div>

  </div>

</div>
