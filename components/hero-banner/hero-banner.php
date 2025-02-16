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
  <div class="container">
    <?php if( !empty($slides) ) : ?>
      <div class="relative overflow-hidden hero-banner__slides md:min-h-screen">
        <?php foreach( $slides as $key => $slide ) : ?>
          <div class="hero-banner__slide h-fit absolute w-full left-1/2 bottom-0 -translate-x-[50%]">
            <div class="justify-center row">
              <div class="w-full col">
                <div class="justify-between row">
                  <div class="w-full col lg:w-5/12 offset-1">
                    <div class="wysiwyg hero-banner__content">
                      <?= $slide['content'] ?>
                    </div>
                  </div>
                  <div class="w-full col lg:w-1/2">
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
            </div>
          </div>
          <button class="[&.is-active]:scale-0 hover:scale-150 z-50 [&.is-active]:pointer-events-none duration-300 ease-in-out absolute flex items-center justify-center rounded-full size-16 hero-banner__slide-btn <?= $key === 0 ? 'is-active' : ''; ?> hero-banner__slide-btn-<?= $key ?>" data-hero-banner-slide-key="<?= $key ?>">
            <svg class='size-8 text-brand-jet icon icon-<?= $slide['icon_svg_icon'] ?>' aria-hidden='true'><use xlink:href='#icon-<?= $slide['icon_svg_icon'] ?>'></use></svg>
          </button>
        <?php endforeach; ?>

      </div>
    <?php endif; ?>
  </div>
  <!-- next button -->
  <!-- <div class="absolute left-1/2 -translate-x-[50%] top-0 flex items-center justify-between h-full w-[calc(100dvw_-_100px)]">
    <button class="hero-banner__next-button">
      <svg class='icon size-8 icon-chevron-right' aria-hidden='true'><use xlink:href='#icon-chevron-right'></use></svg>
    </button>
  </div> -->
</section>

