<?php
/**
* Content Grid
* -----------------------------------------------------------------------------
*
* Content Grid component
*/

$classes = $component_args['classes'] ?? [];
$component_id = $component_args['id'] ?? false;
$defaults = [
  'columns'           => null,
  'size'              => null,
  'narrow'            => false,
  'add_icons'         => false,
  'center_icon'       => false,
  'icon_size'         => null,
  'intro_content'     => null,
  'items'             => [],
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
  'full_screen_height'  => false,
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

$mobile_spacing_array = [
  0 => '0',
  12 => '8',
  14 => '10',
  16 => '12',
  18 => '14',
  20 => '14',
  24 => '16',
  32 => '24',
];

/* if full height, hard set the padding */
if ( !empty( $component_data['full_screen_height'] ) ) {
  $full_screen = 'is-full-screen';
  $mp_amount = $mp . '-' . $mobile_spacing_array[24] . ' '. 'lg:' . $mp . '-24';
} else {
  $full_screen = '';
  if( $component_data['vertical_spacing'] === null ) {
    $mp_amount = $mp . '-' . $mobile_spacing_array[0] . ' '. 'lg:' . $mp . '-0';
  } else {
    $mp_amount = $mp . '-' . $mobile_spacing_array[$component_data['vertical_spacing']] . ' '. 'lg:' . $mp . '-' . $component_data['vertical_spacing'];
  }
}

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
<section class="content-grid relative <?php echo $full_screen; ?> <?php echo $background_color; ?> <?php echo $overlay; ?> <?php echo $mp_amount; ?> <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ) ?> data-component="content-grid">

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
      <div class="col w-full <?php echo $component_data['narrow'] == true && $component_data['columns'] !== '1' ? 'xl:w-10/12' : ''; ?>">
        <div class="row -mb-8 js-fade-group <?php echo $component_data['columns'] == '1' ? 'justify-center' : ''; ?>">
          <?php if (!empty($component_data['intro_content'])) : ?>
            <div class="col w-full mb-8">
              <div class="wysiwyg">
                <?php if ( !empty( $component_data['intro_content_add_icon'] ) ) : ?>
                  <svg class="block icon icon-<?php echo $component_data['intro_content_icon']['svg_icon']; ?> <?php echo !empty( $component_data['intro_content_center_icon'] ) ? 'mx-auto' : ''; ?> <?php echo $component_data['intro_content_icon_size']; ?> <?php echo intval( $component_data['icon_size'] ) > 14 ? 'mb-10' : 'mb-8'; ?>"><use xlink:href="#icon-<?php echo $component_data['intro_content_icon']['svg_icon']; ?>"></use></svg>
                <?php endif; ?>

                <?php echo format_text( $component_data['intro_content'] ); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if ( !empty( $component_data['items'] ) ) : ?>
            <?php foreach ( $component_data['items'] as $key => $item ) : ?>
              <div class="col w-full <?php echo $column_size; ?> mb-8">
                <div class="wysiwyg">
                  <?php if ( !empty( $component_data['add_icons'] ) ) : ?>
                    <svg class="block icon icon-<?php echo $item['icon']['svg_icon']; ?> <?php echo !empty( $component_data['center_icon'] ) ? 'mx-auto' : ''; ?> <?php echo $component_data['icon_size']; ?> <?php echo intval( $component_data['icon_size'] ) > 14 ? 'mb-10' : 'mb-8'; ?>"><use xlink:href="#icon-<?php echo $item['icon']['svg_icon']; ?>"></use></svg>
                  <?php endif; ?>

                  <?php echo $item['content']; ?>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
