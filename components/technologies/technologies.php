<?php
/**
* Technologies
* -----------------------------------------------------------------------------
*
* Technologies component
*/

$classes = $component_args['classes'] ?? [];
$component_id = $component_args['id'] ?? false;
$defaults = [
  'top_row' => [],
  'bottom_row' => [],
];

$component_data = parse_args( $component_data, $defaults );

$top_row = $component_data['top_row'];
$bottom_row = $component_data['bottom_row'];
?>

<?php if ( is_empty( $component_data ) ) return; ?>
<section class="technologies py-20 relative <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="technologies">
  <div class="container flex justify-center mb-12">
    <div class="px-8 py-5 rounded-lg w-fit bg-brand-ivory/90 mix-blend-exclusion backdrop-blur-[2px]">
      <h2 class="text-center text-brand-jet hdg-1">Technologies</h2>
    </div>
  </div>
  <div class="flex flex-col gap-10 overflow-hidden technologies__sliders-wrapper group">
    <?php if( !empty($top_row) ) : ?>
      <div class="splide technologies__top-splide">
        <div class="mx-6 overflow-visible splide__track">
          <div class="splide__list">
            <?php foreach( $top_row as $icon ) :  ?>
              <div class="relative flex justify-center splide__slide">
                <svg class='icon duration-200 size-16 icon-<?= $icon['tech_svg_icon'] ?>' aria-hidden='true'><use xlink:href='#icon-<?= $icon['tech_svg_icon'] ?>'></use></svg>
                <div class="absolute inset-0 flex items-center justify-center font-bold duration-200 paragraph-large tech-name size-full">
                  <?= $icon['name'] ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <?php if( !empty($bottom_row) ) : ?>
      <div class="splide technologies__bottom-splide">
        <div class="mx-6 overflow-visible splide__track">
          <div class="splide__list">
            <?php foreach( $bottom_row as $icon ) : ?>
              <div class="flex justify-center splide__slide">
                <svg class='icon duration-200 size-16 icon-<?= $icon['tech_svg_icon'] ?>' aria-hidden='true'><use xlink:href='#icon-<?= $icon['tech_svg_icon'] ?>'></use></svg>
                <div class="absolute inset-0 flex items-center justify-center font-bold duration-200 paragraph-large tech-name size-full">
                  <?= $icon['name'] ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>

  </div>
</section>
