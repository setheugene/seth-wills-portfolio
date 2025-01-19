<section class="relative z-10 flex items-center text-brand-jet">
  <div class="container">
    <div class="justify-between min-h-[100dvh] row">
      <div class="self-center w-full col lg:w-6/12">
        <h1 class="mb-1 hdg-6">
          Project:
        </h1>
        <h2 class="hdg-1">
          <?= get_field('project_name') ?>
        </h2>
      </div>
      <div class="self-start w-full col lg:w-4/12">
        <div class="p-8 mt-[100px] flex flex-col gap-4 rounded-lg bg-brand-jet/90 text-brand-ivory backdrop-blur-[2px]">
          <div class="flex flex-col">
            <p class="font-bold hdg-5">
              Year Built:
            </p>
            <p class="paragraph-default">
              2021
            </p>
          </div>
          <div class="flex flex-col">
            <p class="font-bold hdg-5">
              CMS:
            </p>
            <p class="paragraph-default">
              Wordpress
            </p>
          </div>
          <div class="flex flex-col">
            <p class="font-bold hdg-5">
              Languages:
            </p>
            <p class="paragraph-default">
              PHP, HTML5, CSS3, Javascript
            </p>
          </div>
          <div class="flex flex-col">
            <p class="font-bold hdg-5">
              Libraries:
            </p>
            <p class="paragraph-default">
              JQuery, Tailwind, GSAP, Slick Slider
            </p>
          </div>
          <a href="<?= the_field('project_url') ?>" class="absolute right-6 top-6 group" target="_blank">
            <div class="relative flex items-center justify-center p-2 rounded-full size-[90px] bg-brand-ivory">
              <div class="duration-200 rounded-full z-10 size-[90px] scale-0 group-hover:scale-100 absolute left-1/2 top-1/2 -translate-x-[50%] -translate-y-[50%] bg-brand-blue"></div>
              <p class="z-20 w-full font-bold text-center duration-300 text-brand-jet paragraph-default">
                Visit Site
              </p>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
  include_component(
    'highlights',
    array(
      'title' => 'highlights',
    )
  );
?>
