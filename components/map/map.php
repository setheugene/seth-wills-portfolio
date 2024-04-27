<?php
/**
* Map
* -----------------------------------------------------------------------------
*
* Map component
*/

$defaults = [
];

$component_data = parse_args( $component_data, $defaults );
?>

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
$component_id = ( isset( $component_args['id'] ) ? $component_args['id'] : false );
?>

<?php if ( is_empty( $component_data ) ) return; ?>
<section class="map py-12 <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="map" data-locations="<?php echo esc_json( json_encode( $component_data['locations'] ) ); ?>">
  <div class="container">
    <div class="justify-center mb-8 row js-fade-group">
      <?php if( isset($component_data['hdg']) && isset($component_data['hdg']['text'] )) : ?>
        <div class="w-5/12 col">
          <<?php echo $component_data['hdg']['tag']; ?> class="hdg-3"><?php echo $component_data['hdg']['text']; ?></<?php echo $component_data['hdg']['tag']; ?>>
        </div>
      <?php endif; ?>

      <?php if ( isset($component_data['content']) ) : ?>
        <div class="w-5/12 col">
          <div class="wysiwyg">
            <?php echo $component_data['content']; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <?php if ( isset($component_data['locations']) ) : ?>
      <div class="row js-reveal">
        <div class="mx-auto w-full lg:w-10/12 col">
          <div class="relative aspect-16/9">
            <div class="absolute top-0 left-0 w-full h-full map-box" id="map-<?php echo $component_id; ?>" style="position:absolute!important;"></div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
