<?php
$categories = get_terms( array(
    'taxonomy' => 'category',
    'hide_empty' => true,
) );

$tags = get_terms( array(
    'taxonomy' => 'post_tag',
    'hide_empty' => true,
) );

$newsletter = get_field( 'blog_newsletter', get_option('page_for_posts') );
?>

<button class="flex items-end justify-between w-full pb-3 mb-3 border-b border-black blog__sidebar-toggle lg:hidden hdg-4" data-toggle-target-next data-toggle-class="is-open" aria-expanded="false">Filter <svg class="text-xl icon icon-chevron-down"><use xlink:href="#icon-chevron-down"></use></svg></button>

<div class="hidden space-y-5 blog__sidebar-inner lg:block" aria-hidden="false">
  <?php if ( $categories ) : ?>
    <div class="blog__sidebar-block blog__block blog__block--categories">
      <h2 class="blog__sidebar-title blog__block-title">Categories</h2>

      <ul class="space-y-2 blog__block-list categories">
        <?php foreach ( $categories as $key => $cat ) : ?>
          <li>
            <a href="<?php echo get_term_link( $cat->term_id, 'category' ); ?>" class="<?php echo get_queried_object_id() == $cat->term_id ? 'is-active' : ''; ?>"><?php echo $cat->name; ?> (<?php echo $cat->count; ?><span class="sr-only"> Posts</span>)</a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <?php if ( $tags ) : ?>
    <div class="blog__sidebar-block blog__block blog__block--tags">
      <h2 class="blog__sidebar-title blog__block-title">Tags</h2>

      <ul class="blog__block-list tags">
        <?php foreach ( $tags as $key => $tag ) : ?>
          <li>
            <a href="<?php echo get_term_link( $tag->term_id, 'post_tag' ); ?>" class="<?php echo get_queried_object_id() == $tag->term_id ? 'is-active' : ''; ?>">
              <?php echo $tag->name; ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <?php if ( isset($newsletter['form_id']) && $newsletter['form_id'] ) : ?>
    <div class="blog__sidebar-block blog__block blog__block--newsletter">
      <?php if ( isset($newsletter['title']) && $newsletter['title'] ) : ?>
        <h2 class="blog__sidebar-title blog__block-title">
          <?php echo $newsletter['title']; ?>
        </h2>
      <?php endif; ?>

      <?php if ( isset($newsletter['text']) && $newsletter['text'] ) : ?>
        <p class="blog__newsletter-text">
          <?php echo $newsletter['text']; ?>
        </p>
      <?php endif; ?>

      <?php gravity_form( $newsletter['form_id'], false, false, false, '', true ); ?>
    </div>
  <?php endif; ?>
</div>
