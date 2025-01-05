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
];

$component_data = parse_args( $component_data, $defaults );

$projects = $component_data['projects'];
?>

<?php if ( is_empty( $component_data ) ) return; ?>
<section class="projects bg-brand-jet/60 backdrop-blur-[2px] <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="projects">
  <div class="py-3 border-y border-brand-ivory/50">
    <div class="container">
      <h2 class="hdg-2">
        Projects
      </h2>
    </div>
  </div>
  <?php if(!empty($projects)) : ?>
    <div class="">
      <div class="grid grid-cols-2">
        <?php foreach($projects as $key => $project_id) : ?>
          <div class="relative flex items-center justify-center group border-b border-brand-ivory/50 <?= $key % 2 ? '' : 'border-r'; ?>">
            <h3 class="relative z-10 px-[180px] py-20 text-center hdg-4 opacity-100 group-hover:opacity-0 pointer-events-none">
              <?= get_field('project_name', $project_id) ?>
            </h3>
            <div class="absolute inset-0 grid grid-cols-2 size-full">
              <a href="<?= get_field('project_code', $project_id) ?>" target="_blank" class="flex items-center justify-center font-bold text-center duration-300 border-r opacity-0 paragraph-large size-full border-brand-ivory/50 group-hover:opacity-100 hover:bg-brand-red/40 hover:backdrop-blur-sm">
                See Code
              </a>
              <a href="<?= get_field('project_site', $project_id) ?>" target="_blank" class="flex items-center justify-center font-bold text-center duration-300 border-r opacity-0 paragraph-large size-full border-brand-ivory/50 group-hover:opacity-100 hover:bg-brand-blue/40 hover:backdrop-blur-sm">
                Go to Site
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>
</section>
