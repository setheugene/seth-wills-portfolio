<?php
/**
* Hero Banner
* -----------------------------------------------------------------------------
*
* Hero Banner component
*/

$classes = $component_args['classes'] ?? [];
$component_id = $component_args['id'] ?? false;
$defaults = [
  'slides' => [],
];

$component_data = parse_args( $component_data, $defaults );
$slides = $component_data['slides'];

?>

<?php if ( is_empty( $component_data ) ) return; ?>
<section class="hero-banner relative flex justify-center items-end <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="hero-banner">
  <button class="hero-banner__button">button</button>
  <div class="container">
    <?php if( !empty($slides) ) : ?>
      <div class="relative overflow-hidden hero-banner__slides md:min-h-screen">
        <?php foreach( $slides as $key => $slide ) : ?>
          <div class="hero-banner__slide h-fit absolute w-full left-1/2 bottom-0 -translate-x-[50%]">
            <div class="justify-between row">
              <div class="w-full col lg:w-1/2">
                <div class="wysiwyg hero-banner__content">
                  <?= $slide['content'] ?>
                </div>
              </div>
              <div class="w-full col lg:w-5/12">
                <div class="relative aspect-square hero-banner__image">
                  <?php if($slide['cutout_image_png']) : ?>
                    <?php
                      include_component(
                        'fit-image',
                        array(
                          'image_id' => $slide['cutout_image_png'],
                          'thumbnail_size' => 'full',
                          'position' => '',
                          'fit' =>  '',
                          'loading' => ''
                        ),
                      );
                    ?>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

      </div>
    <?php endif; ?>
  </div>
</section>

