<?php
  $primary_menu   = new Menu( 'primary_navigation' );
?>
<header id="navbar" class="flex px-28 items-center py-4 navbar text-brand-jet bg-brand-ivory/60 backdrop-blur-[2px]" role="banner">
  <div class="relative flex items-end w-full h-full">
    <div class="flex items-end justify-between w-full flex-nowrap">

      <button type="button" class="md:hidden navbar-toggle" data-toggle-class="is-open" data-toggle-target="#primary-nav">
        <span class="navbar-toggle-icon"></span>
        <span class="sr-only">Main Menu</span>
      </button>

      <div class="hdg-6">
        Seth Wills
      </div>

      <nav class="hidden md:block primary-nav" id="primary-nav" role="navigation">
        <ul class="flex">
          <?php if ( $primary_menu->items ) : ?>
            <?php foreach( $primary_menu->items as $menu_item ) : ?>
              <li class="mr-8 primary-menu-item last:mr-0">
                <<?php echo $menu_item->has_children ? 'button' : 'a'; ?> class="inline-block font-bold duration-200 paragraph-large text-brand-jet"
                  <?php if( $menu_item->has_children ) : ?>
                    data-toggle-class="is-open"
                    data-toggle-target="#menu-<?php echo $menu_item->ID; ?>" aria-expanded="false"
                    data-toggle-group="menu-accordions"
                    id="item-<?php echo $menu_item->ID; ?>"
                    <?php else : ?>
                    href="<?php echo $menu_item->url ?>"
                    target="<?php echo $menu_item->target; ?>"
                  <?php endif; ?>
                >
                  <?php echo $menu_item->title; ?>

                  <?php if ( $menu_item->has_children ) : ?>
                    <span class="inline-block">
                      <svg class="icon icon-chevron-down" aria-hidden="true"><use xlink:href="#icon-chevron-down"></use></svg>
                    </span>
                  <?php endif; ?>
                </<?php echo $menu_item->has_children ? 'button' : 'a'; ?>>

                <?php if ( $menu_item->has_children ) : ?>
                  <div class="hidden" id="menu-<?php echo $menu_item->ID; ?>" aria-hidden="true" aria-labelledby="item-<?php echo $menu_item->ID; ?>">
                    <ul>
                      <?php foreach ( $menu_item->children as $child_item ) : ?>
                        <li class="">
                          <a href="<?php echo $child_item->url; ?>" target="<?php echo $child_item->target; ?>"><?php echo $child_item->title; ?></a>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          <?php endif; ?>
        </ul>
      </nav>

    </div>
  </div>
  <button id="primary-nav__trigger" class="absolute flex items-center justify-center w-10 h-8 duration-300 rounded-b-lg hover:h-10 hover:-bottom-10 group after:absolute after:bottom-0 after:size-12 -bottom-8 right-20 bg-brand-ivory/60" data-toggle-target="#navbar" data-toggle-class="is-open">
    <svg class='icon size-5 text-brand-jet icon-chevron-down group-[&.is-open]:rotate-180 duration-300' aria-hidden='true'><use xlink:href='#icon-chevron-down'></use></svg>
  </button>
</header>
