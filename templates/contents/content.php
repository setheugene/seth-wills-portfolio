<?php
/**
 * Any additional classes to apply to the main component container.
 *
 * @var array
 * @see args['classes']
 */
$classes = ( isset( $component_args['classes'] ) ? $component_args['classes'] : array() );

/**
 * ID to apply to the main component container.
 *
 * @var array
 * @see args['id']
 */
$component_id   = ( isset( $component_args['id'] ) ? $component_args['id'] : false );

$post = !empty($component_data['post']) ? $component_data['post'] : get_the_ID();
?>
<article <?php post_class(implode( " ", $classes ), $post ); ?> <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?>>
  <?php
    $cats = get_the_terms( $post, 'category' );
    $corner_tag = true;
    $content_tag = false;
  ?>
  <a class="post__card group" href="<?php echo get_permalink($post) ?>" title="Read more about <?php echo get_the_title($post); ?>">
    <div class="overflow-hidden relative post__image-wrapper aspect-2/3">
      <?php
        include_component(
          'fit-image',
          array(
            'image_id' => get_post_thumbnail_id($post),
            'position' => 'object-center'
          ),
          array(
            'classes' => ['post__image']
          )
        );
      ?>

      <?php if ( !empty($cats[0]) && $corner_tag ) : ?>
        <div class="post__category-corner-tag flex-col z-10 relative group-hover:text-brand-ivory text-xl uppercase paragraph-large px-3 pt-1 text-center w-1/2 group-hover:w-full group-hover:bg-transparent h-10 flex items-center justify-center duration-200 ease-in-out bg-brand-ivory text-brand-jet">
          <p><?php echo $cats[0]->name; ?></p>
        </div>
      <?php endif; ?>
      <div class="absolute opacity-0 inset-0 h-full w-full duration-200 ease-in-out flex items-center justify-center p-3 group-hover:opacity-100 bg-black/60">
        <div class="hdg-3 text-center w-full text-brand-ivory">
          <?php echo get_the_title( $post ); ?>
        </div>
      </div>
    </div>

    <div class="post__content">

      <h2 class="post__title"><?php echo get_the_title( $post ); ?></h2>
    </div>

    <div class="post__read-more-wrapper">
      <span class="post__read-more">Learn More</span>
    </div>
  </a>
</article>
