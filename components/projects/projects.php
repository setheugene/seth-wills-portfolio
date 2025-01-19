<?php
/**
* Projects
* -----------------------------------------------------------------------------
*
* Projects component
*/

$classes = $component_args['classes'] ?? [];
$component_id = $component_args['id'] ?? false;
$defaults = [
  'projects' => [],
  'code_popup' => null,
];

$component_data = parse_args( $component_data, $defaults );

$projects = $component_data['projects'];
$code_popup = $component_data['code_popup'];
?>

<?php if ( is_empty( $component_data ) ) return; ?>
<section class="projects py-20 relative z-10 <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="projects">
  <div class="mb-12">
    <div class="container">
      <h2 class="relative mx-auto text-center w-fit text-brand-ivory hdg-1">
        Projects
        <button class="absolute top-0 flex items-center justify-center duration-300 rounded-full hover:bg-brand-green -right-6 size-6 text-brand-jet bg-brand-ivory js-init-popup" data-modal="#projects__code-snippet" data-component="modal">
          <svg class='size-4 icon icon-code' aria-hidden='true'><use xlink:href='#icon-code'></use></svg>
        </button>
      </h2>
    </div>
  </div>
  <?php if(!empty($projects)) : ?>
    <div id="grid-layout" class="max-w-[1600px] mx-auto">
      <div class="projects__grid">
        <?php foreach($projects as $key => $project_id) : ?>
          <div class="grid-tile px-8 py-5 relative tile-<?= $key + 1 ?>" data-grid="tile-<?= $key + 1 ?>">
            <?php
              include_component(
                'fit-image',
                array(
                  'image_id' => get_post_thumbnail_id($project_id),
                  'thumbnail_size' => 'large',
                  'position' => '',
                  'fit' =>  '',
                  'loading' => '',
                ),
                ["classes" => ["opacity-0 duration-500 delay-500"]]
              );
            ?>
            <div class="absolute inset-0 duration-300 bg-brand-ivory/70 backdrop-blur-[2px] grid-tile__bg-color size-full"></div>
            <div class="absolute inset-0 duration-1000 bg-black opacity-0 grid-tile__overlay size-full"></div>
            <h2 class="absolute top-1/2 left-1/2 -translate-y-[50%] -translate-x-[50%] z-10 paragraph-large font-bold text-center duration-500 w-[180px] grid-tile__small-heading text-brand-jet"><?= get_field('project_name', $project_id) ?></h2>
            <div class="absolute opacity-0 flex-col gap-5 duration-500 top-1/2 left-1/2 delay-500 -translate-y-[50%] -translate-x-[50%] z-10 grid-tile__large-heading flex justify-center items-center">
              <h2 class="hdg-2 text-center w-[450px] text-brand-ivory"><?= get_field('project_name', $project_id) ?></h2>
              <a href="<?= get_the_permalink($project_id) ?>" class="pointer-events-none btn-secondary">View Details</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>
</section>
<?php if( $code_popup ) : ?>
  <div id="projects__code-snippet" class="modal_code-snippet mfp-hide modal code-modal">
    <div class="relative aspect-square">
      <?php
        include_component(
          'fit-image',
          array(
            'image_id' => $code_popup['image_id'],
            'thumbnail_size' => 'large',
            'position' => $code_popup['image_focus_point'],
            'fit' =>  $code_popup['image_fit'],
            'loading' => 'eager',
          )
        );
      ?>
    </div>
  </div>
<?php endif; ?>
