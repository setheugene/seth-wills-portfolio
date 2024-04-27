<?php
/**
* Loop Video
* -----------------------------------------------------------------------------
*
* Loop Video component
* Displays a looped video with a custom poster image for the video element, lazy loads the src for the looped video, and adds a play/pause button on desktop only display options.
*
* display parameter - determines at what screen size the video will load/play automatically. Can be set to either mobile or desktop. (similar set up to mobile first css).
* mobile = loads video when scrolled to on all screen sizes ( play/pause button will not be added ) - NOT ADA
* desktop = desktop - loads video when scrolled to on desktop, mobile - only loads when user presses the play button   - USE FOR ADA SITES
*
*
* play/pause button can be moved out to the component using the loop-video component
*
*
*/

$classes = $component_args['classes'] ?? [];
$component_id = $component_args['id'] ?? false;
$defaults = [
  'video' => null,
  'fallback' => null,
  'display' => 'mobile',
  'thumbnail_size' => 'full',
  'position' => 'object-center',
  'loading' => true
];

$component_data = parse_args( $component_data, $defaults );
?>

<?php if ( is_empty( $component_data ) ) return; ?>
<div class="video-image-container <?php echo $component_data['display']; ?> <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ) ?> data-component="loop-video">
  <div class="loop-video-container">
    <video class="loop-video lazy is-paused <?php echo $component_data['display']; ?>" muted autoplay loop playsinline poster="<?php echo $component_data['fallback']; ?>">
      <source data-src="<?php echo $component_data['video']; ?>">
    </video>
    <?php if($component_data['display'] === 'desktop') : ?>
      <button type="button" class="is-paused loop-video-btn loop-video-toggle-state" title="Play looping video">
        <svg class="icon icon-pause-loop"><use xlink:href="#icon-pause-loop"></use></svg>
        <svg class="icon icon-play-loop"><use xlink:href="#icon-play-loop"></use></svg>
      </button>
    <?php endif; ?>
  </div>
  <?php
    if($component_data['image_id']) {
      include_component(
        'fit-image',
        array(
          'image_id' => $component_data['image_id'],
          'thumbnail_size' => $component_data['thumbnail_size'],
          'position' => $component_data['position'],
          'loading' => $component_data['loading']
        ),
        [
          'classes' => ['loop-video-image']
        ]
      );
    }
  ?>
</div>
