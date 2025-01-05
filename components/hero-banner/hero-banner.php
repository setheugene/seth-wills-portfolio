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
  'heading' => array(
    'tag'  => 'h2',
    'text' => null
  ),
  'image_id' => null,
  'image_focus_point' => null,
  'content' => '',
];

$component_data = parse_args( $component_data, $defaults );
?>

<?php if ( is_empty( $component_data ) ) return; ?>
<section class="hero-banner relative flex justify-center items-end pt-20 md:min-h-[calc(100vh_-_59px_-_var(--wp-admin--admin-bar--height,0))] <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="hero-banner">
  <div class="container">
    <div class="justify-center row">
      <div class="w-full col">
        <div class="justify-between row">
          <div class="w-full col lg:w-1/2 lg:offset-1">
            <div class="wysiwyg">
              <?php if( $component_data['heading'] && $component_data['heading']['text'] ) : ?>
                <<?php echo $component_data['heading']['tag']; ?> class="mb-0 hdg-1 text-brand-ivory js-fade"><?php echo $component_data['heading']['text']; ?></<?php echo $component_data['heading']['tag']; ?>>
              <?php endif; ?>
              <div class="wysiwyg">
                <?php echo $component_data['content']; ?>
              </div>
            </div>
          </div>
          <div class="w-full col lg:w-5/12">
            <div class="relative aspect-square">
              <?php if($component_data['image_id']) : ?>
                <?php
                  include_component(
                    'fit-image',
                    array(
                      'image_id' => $component_data['image_id'],
                      'thumbnail_size' => 'full',
                      'position' => $component_data['image_focus_point'],
                      'fit' =>  $component_data['image_fit'],
                      'loading' => $component_data['image_loading']
                    )
                  );
                ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

