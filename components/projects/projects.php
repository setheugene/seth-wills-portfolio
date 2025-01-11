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
    <div class="relative flex flex-col items-center justify-center h-screen space-y-10">
      <?php foreach($projects as $key => $project_id) : ?>
        <div id="project-<?= $project_id ?>" class="duration-500 ease-in-out opacity-0 pointer-events-none [&.is-active]:opacity-100">
          <?php
            include_component(
              'fit-image',
              array(
                'image_id' => get_post_thumbnail_id($project_id),
                'thumbnail_size' => 'large',
                'position' => '',
                'fit' =>  '',
                'loading' => '',
              )
            );
          ?>
        </div>
        <div class="relative z-10 w-full group projects__title" data-target="#project-<?= $project_id ?>">
          <h3 class="text-center duration-300 text-brand-ivory group-hover:opacity-0 hdg-3"><?= get_field('project_name', $project_id) ?></h3>
          <div class="absolute top-[100%] left-0 grid grid-cols-2 duration-300 opacity-0 size-full group-hover:opacity-100">
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
  <?php endif; ?>
</section>
