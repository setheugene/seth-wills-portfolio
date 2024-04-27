<?php
/**
* Left Right
* -----------------------------------------------------------------------------
*
* Left Right component
*/

$classes = $component_args['classes'] ?? [];
$component_id = $component_args['id'] ?? false;
$defaults = [
  'add_icon'          => false,
  'icon_size'         => null,
  'content'           => '',
  'image_id'          => null,
  'image_focus_point' => null,
  'image_fit'         => null,
  'image_loading'     => null,
  'layout'            => 'content-image',
  'background_type'   => 'background-color',
  'background_color'  => 'bg-white',
  'background_image'  => [
    'image_id'          => null,
    'image_focus_point' => null,
    'image_fit'         => null,
    'image_loading'     => null,
  ],
  'overlay'           => [
    'enable_overlay'    => false,
    'color'             => null,
    'text_color'        => null,
  ],
  'vertical_spacing'    => null,
  'sizing'              => 'default',
  'align_items'         => 'items-start',
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

/**
 * Content Column Classes
 */

$content_col_order = 'lg:order-1';
if ( $component_data['layout'] == 'image-content' ) {
  $content_col_order = 'lg:order-2';
}

$content_col_width = 'lg:w-6/12';
if ( $component_data['sizing'] == 'narrow' || $component_data['sizing'] == 'narrow-content' ) {
  $content_col_width = 'lg:w-5/12';
}

$content_col_offset = '';
if ( $component_data['layout'] == 'content-image' && ( $component_data['sizing'] == 'narrow' || $component_data['sizing'] == 'narrow-content' ) ) {
  $content_col_offset = 'lg:offset-1';
}

/**
 * Image Column Classes
 */

$image_col_order = 'lg:order-1';
if ( $component_data['layout'] == 'content-image' ) {
  $image_col_order = 'lg:order-2';
}

$image_col_width = 'lg:w-6/12';
if ( $component_data['sizing'] == 'narrow' ) {
  $image_col_width = 'lg:w-5/12';
}

$image_col_offset = '';
if ( $component_data['layout'] == 'image-content' && $component_data['sizing'] == 'narrow' ) {
  $image_col_offset = 'lg:offset-1';
}
?>

<?php if ( is_empty( $component_data ) ) return; ?>
<section class="left-right relative <?php echo $background_color; ?> <?php echo $overlay; ?> <?php echo $mp_amount; ?> <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ) ?> data-component="left-right">

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
    <div class="row <?php echo $component_data['align_items']; ?>">
      <div class="col w-full order-2 <?php echo $content_col_order; ?> <?php echo $content_col_width; ?> <?php echo $content_col_offset; ?>">
        <div class="wysiwyg">
          <?php if ( !empty( $component_data['add_icon'] ) ) : ?>
            <svg class="block icon icon-<?php echo $component_data['icon']['svg_icon']; ?> <?php echo $component_data['icon_size']; ?> <?php echo intval( $component_data['icon_size'] ) > 14 ? 'mb-10' : 'mb-8'; ?> "><use xlink:href="#icon-<?php echo $component_data['icon']['svg_icon']; ?>"></use></svg>
          <?php endif; ?>

          <?php echo $component_data['content']; ?>
        </div>
      </div>

      <div class="col w-full order-1 mb-10 lg:mb-0 <?php echo $image_col_order; ?> <?php echo $image_col_width; ?> <?php echo $image_col_offset; ?>">
        <?php if ( $component_data['image_fit'] == 'object-cover' ) : ?>
          <div class="relative <?php echo $component_data['image_aspect_ratio']; ?>">
            <?php
              include_component(
                'fit-image',
                [
                  'image_id'            => $component_data['image_id'],
                  'thumbnail_size'      => 'large',
                  'position'            => $component_data['image_focus_point'],
                  'fit'                 => $component_data['image_fit'],
                  'loading'             => $component_data['image_loading'],
                ]
              );
            ?>
          </div>
        <?php else : ?>
          <?php echo wp_get_attachment_image($component_data['image_id'], 'large', false, ['loading' => $component_data['image_loading'] ? 'lazy' : 'eager']); ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
