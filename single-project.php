<?php
$project_id = get_the_ID();
?>
<section class="relative z-10 flex items-center text-brand-jet">
  <div class="container">
    <div class="justify-between row min-h-[calc(100dvh_-_var(--topOffset))]">
      <div class="self-center w-full col lg:w-6/12">
        <h1 class="mb-1 hdg-6">
          Project:
        </h1>
        <h2 class="hdg-1">
          <?= get_field('project_name', $project_id) ?>
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
          <a href="#" class="absolute right-6 top-6 group">

            <div class="duration-200 border rounded-full size-20 group-hover:size-[120px] absolute-center border-brand-blue"></div>
            <div class="relative flex items-center justify-center p-2 rounded-full size-[90px] bg-brand-ivory">
              <p class="z-10 w-full font-bold text-center duration-300 text-brand-jet paragraph-default">
                Visit Site
              </p>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
