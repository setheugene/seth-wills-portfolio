<?php
/**
* Highlights
* -----------------------------------------------------------------------------
*
* Highlights component
*/

$classes = $component_args['classes'] ?? [];
$component_id = $component_args['id'] ?? false;
$defaults = [
  'highlights' => [],
];

$component_data = parse_args( $component_data, $defaults );

$highlights = $component_data['highlights'];
?>

<?php if ( is_empty( $component_data ) ) return; ?>
<section class="highlights flex no-wrap <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="highlights">
  <?php if( !empty($highlights) ) : ?>
    <?php foreach( $highlights as $highlight ) : ?>
      <div class="flex-none w-screen border panel border-brand-red">
        <div class="container">
          <div class="items-center h-screen row">
            <div class="w-full col lg:w-5/12">
              <div class="text-left hdg-2 text-brand-jet">
                <div class="wysiwyg text-brand-jet">
                  <?= $highlight['content'] ?>
                </div>
              </div>
            </div>
            <div class="w-full col lg:w-7/12">
              <div class="p-8 rounded-lg bg-brand-jet">
                <div class="text-brand-ivory">
                  <pre class="code paragraph-default">
                    <?= $highlight['code'] ?>
                  </pre>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</section>
