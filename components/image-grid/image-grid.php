<?php
/**
* Image Grid
* -----------------------------------------------------------------------------
*
* Image Grid component
*/

$classes = $component_args['classes'] ?? [];
$component_id = $component_args['id'] ?? false;
$defaults = [
  'columns'             => null,
  'add_container'       => false,
  'size'                => null,
  'narrow'              => false,
  'images'              => [],
  'vertical_spacing'    => null,
  'image_aspect_ratio'  => null,
  'background_color'    => 'bg-white',
];

$component_data = parse_args( $component_data, $defaults );

/* set column size */
$column_size = 'lg:w-1/' . $component_data['columns'];
$image_size = 'large';
if ( $component_data['columns'] == '1' ) {
  $column_size = $component_data['size'];
  $image_size = 'full';
} elseif ( $component_data['columns'] == '4' ) {
  $column_size = 'md:w-1/2 lg:w-1/3 xl:w-1/4';
  $image_size = 'medium';
} elseif ( $component_data['columns'] == '5' ) {
  $column_size = 'sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5';
  $image_size = 'medium';
}

$background_color = isset( $component_data['background_color'] ) ? $component_data['background_color'] : 'bg-white';

/* set margin or padding */
$mp = 'my';
if ( $background_color !== 'bg-white' ) {
  $mp = 'py';
}

/* if full height, hard set the padding */
if ( empty( $component_data['add_container'] ) && $component_data['image_aspect_ratio'] == 'h-screen--reduced' ) {
  $mp_amount = '';
} else {
  $mp_amount = $mp . '-' . $component_data['vertical_spacing'];
}
?>

<?php if ( is_empty( $component_data ) ) return; ?>
<section class="image-grid overflow-hidden <?php echo $background_color; ?> <?php echo $mp_amount; ?> <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="image-grid">
  <div class="<?php echo !empty( $component_data['add_container'] ) ? 'container' : ''; ?>">
    <div class="justify-center row">
      <div class="col w-full <?php echo !empty( $component_data['narrow'] ) ? 'xl:w-10/12' : ''; ?>">
        <div class="-mb-8 row">
          <?php foreach ( $component_data['images'] as $key => $image ) : ?>
            <div class="col w-full <?php echo $column_size; ?> <?php echo intval( $component_data['columns'] ) >= count( $component_data['images'] ) ? 'mx-auto' : ''; ?> mb-8">
              <div class="relative <?php echo $component_data['image_aspect_ratio']; ?>">
                <?php
                  include_component(
                    'fit-image',
                    [
                      'image_id'            => $image['image_id'],
                      'thumbnail_size'      => $image_size,
                      'position'            => $image['image_focus_point'],
                      'fit'                 => $image['image_fit'],
                      'loading'             => $image['image_loading'],
                    ]
                  );
                ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
