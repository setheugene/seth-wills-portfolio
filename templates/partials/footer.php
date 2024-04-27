<?php
  $logo  = get_field( 'global_footer_logo', 'option' );
  /*
   * create as an array to loop through
   * if they're in a list, or create them individually
   *
   * Call individually
   * $footer_menu_one = new Menu( 'footer_menu_one' );
   * $footer_menu_two = new Menu( 'footer_menu_two' );
  */

  $menus = array(
    new Menu( 'footer_menu_one' ),
    new Menu( 'footer_menu_two' )
  );
?>
<footer class="footer bg-brand-jet text-brand-ivory" role="contentinfo">
  <div class="container py-12">
    <div class="row justify-between">
      <?php if ( $logo ) : ?>
        <div class="w-full col lg:w-1/2">
          <a class="inline-block" href="<?php echo esc_url(home_url('/')); ?>">
            <img class="logo logo--footer h-[200px] w-[200px]" src="<?php echo $logo['url']; ?>" alt="<?php bloginfo('name'); ?>">
          </a>
        </div>
      <?php endif; ?>

      <?php foreach ( $menus as $menu ) : ?>
        <div class="w-full md:w-4/12 col">
          <?php if ( isset($menu->hasItems) ) : ?>
            <nav class="">
              <h4 class=""><?php echo $menu->name; ?></h4>
              <ul>
                <?php foreach( $menu->items as $menu_item ): ?>
                  <li class="">
                    <a class="paragraph-default text-brand-ivory duration-200 hover:text-brand-gold" href="<?php echo $menu_item->url ?>" target="<?php echo $menu_item->target; ?>"><?php echo $menu_item->title; ?></a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </nav>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</footer>
