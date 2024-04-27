<?php
/**
* Image Content Cards
* -----------------------------------------------------------------------------
*
* Image Content Cards component
*/

$classes = $component_args['classes'] ?? [];
$component_id = $component_args['id'] ?? false;
$defaults = [
  'columns'             => null,
  'size'                => null,
  'cards'               => [],
  'image_aspect_ratio'  => null,
  'space_below_image'   => 'mb-8',
  'vertical_spacing'    => null,
  'background_type'     => 'background-color',
  'background_color'    => 'bg-white',
  'background_image'    => [
    'image_id'            => null,
    'image_focus_point'   => null,
    'image_fit'           => null,
    'image_loading'       => null,
  ],
  'overlay'             => [
    'enable_overlay'      => false,
    'color'               => null,
    'text_color'          => null,
  ],
];

$component_data = parse_args( $component_data, $defaults );

$background_color = isset( $component_data['background_color']['background_color'] ) ? $component_data['background_color']['background_color'] : 'bg-white';
if ( $component_data['background_type'] == 'background-image' ) {
  $background_color = 'bg-image';
}

/* set margin or padding */
$mp = 'my';
if ( $background_color !== 'bg-white' ) {
  $mp = 'py';
}
$mp_amount = $mp . '-' . $component_data['vertical_spacing'];

/* set overlay type */
$overlay = null;
if ( $component_data['background_type'] == 'background-image' && !empty( $component_data['overlay']['enable_overlay'] ) && $component_data['overlay']['text_color'] == 'light' ) {
  $overlay = 'bg-image--overlay-dark'; // dark overlay, light text
}

/* set column size */
$column_size = 'lg:w-1/' . $component_data['columns'];
if ( $component_data['columns'] == '1' ) {
  $column_size = $component_data['size'];
} elseif ( $component_data['columns'] == '4' ) {
  $column_size = 'md:w-1/2 lg:w-1/3 xl:w-1/4';
} elseif ( $component_data['columns'] == '5' ) {
  $column_size = 'sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5';
}
?>

<?php if ( is_empty( $component_data ) ) return; ?>
<section class="image-content-cards relative <?php echo $background_color; ?> <?php echo $overlay; ?> <?php echo $mp_amount; ?> <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="image-content-cards">

  <?php
    if ( $component_data['background_type'] == 'background-image' ) {
      include_component(
        'fit-image',
        [
          'image_id'            => $component_data['background_image']['image_id'],
          'thumbnail_size'      => 'full',
          'position'            => $component_data['background_image']['image_focus_point'],
          'fit'                 => $component_data['background_image']['image_fit'],
          'loading'             => $component_data['background_image']['image_loading'],
        ]
      );
    }
  ?>

  <?php if ( $component_data['background_type'] == 'background-image' && !empty( $component_data['overlay']['enable_overlay'] ) ) : ?>
    <div class="absolute inset-0 content-grid__overlay" style="background-color: <?php echo $component_data['overlay']['color']; ?>"></div>
  <?php endif; ?>

  <div class="container relative z-10">
    <div class="justify-center row">
      <div class="w-full col <?php echo $component_data['size']; ?>">
        <div class="-mb-8 row">
          <?php foreach ( $component_data['cards'] as $key => $card ) : ?>
            <div class="w-full mb-8 col <?php echo $column_size; ?>">
              <div class="relative <?php echo $component_data['image_aspect_ratio']; ?> mb-<?php echo $component_data['space_below_image']; ?>">
                <?php
                  include_component(
                    'fit-image',
                    [
                      'image_id'            => $card['image_id'],
                      'thumbnail_size'      => 'large',
                      'position'            => $card['image_focus_point'],
                      'fit'                 => $card['image_fit'],
                      'loading'             => $card['image_loading'],
                    ]
                  );
                ?>
              </div>

              <div class="wysiwyg">
                <?php echo $card['content']; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>

</section>
