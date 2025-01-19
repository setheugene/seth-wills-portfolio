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
];

$component_data = parse_args( $component_data, $defaults );
?>

<?php if ( is_empty( $component_data ) ) return; ?>
<section class="highlights flex no-wrap <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="highlights">
  <div class="flex-none w-screen border panel border-brand-red">
    <div class="container">
      <div class="items-center row h-[calc(100dvh_-_var(--topOffset))]">
        <div class="w-full border-r col lg:w-1/2 border-brand-jet">
          <div class="text-center hdg-2 text-brand-jet">
            Challenge
          </div>
        </div>
        <div class="w-full col lg:w-1/2">
          <div class="text-center hdg-2 text-brand-jet">
            Code
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="flex-none w-screen border panel border-brand-red">
    <div class="container">
      <div class="items-center row h-[calc(100dvh_-_var(--topOffset))]">
        <div class="w-full border-r col lg:w-1/2 border-brand-jet">
          <div class="text-center hdg-2 text-brand-jet">
            Challenge
          </div>
        </div>
        <div class="w-full col lg:w-1/2">
          <div class="text-center hdg-2 text-brand-jet">
            Code
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
