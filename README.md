# Wordpress Theme
###### README Version 1.0.0

## Requirements
  - [Node.js](https://nodejs.org/en/download/) - Use v16.16.0
  - [Hygen](http://www.hygen.io/) - See /_templates under Theme Structure for help commands
  - [Advanced Custom Fields Pro](https://www.advancedcustomfields.com/pro/) - Installed automatically on plugin activation
(base theme) - Version Control

## Dependencies
  - [Tailwind](https://tailwindcss.com/) - Utility classes used in a majority of the theme. To use these utility classes in CSS files you can reference them using `@apply my-4 text-center;` as an example. Please refer to [their documentation](https://tailwindcss.com/docs) for more information on how to use Tailwind.
  - [GSAP](https://greensock.com/docs/v3/GSAP) and [ScrollTrigger](https://greensock.com/docs/v3/Plugins/ScrollTrigger) - Used for site animations
  - [Easy Toggle State](https://twikito.github.io/easy-toggle-state/) - JavaScript library for easy toggle state management
  - [Slick Slider](http://kenwheeler.github.io/slick/) - JavaScript library used for carousel sliders
  - [Magnific Popup](https://dimsemenov.com/plugins/magnific-popup/documentation.html) - JavaScript library used for modal popups

## Plugins
  - [Classic Editor](https://wordpress.org/plugins/classic-editor/) - Installed automatically on plugin activation
  - [Gravity Forms](https://www.gravityforms.com/) - WordPress plugin used to create forms on the site, installed automatically on plugin activation

## Helpful Tools
  - [Node Version Manager](https://github.com/creationix/nvm) - Allows for quick changing between Node.js versions
  - [Local By Flywheel](https://local.getflywheel.com/) - Easy-to-use complete development environment for WordPress sites
  - [SourceTree](https://www.sourcetreeapp.com/) - GUI client for source control

## Development Environment Setup
  - Once the theme has been pulled down, open the theme folder in the editor of your choice
  - Open Terminal, and change directory to the theme folder
  - Ensure you are using node 16 (you can check using `node -v`, if you have Node Version Manager you can switch using `nvm use 16`)
  - Run the command `npm install` to install the theme dependencies
  - Run the command `npm run watch` to begin listening for changes to the .js and .css files (these compile into main.min.css and scripts.min.js)
  - For a shorter compile time, run the command `npm run watch-front` to only compile CSS and JS for the front end of the site

## Common Issues
  - If there are version issues that appear when running `npm install`, delete /node_modules folders and rerun `npm install`. Make sure you are using Node version 16.16.0 (`node -v`). Change Node version with Node Version Manager.

## Theme Structure
Overview of the important files present across the theme.

  - __404.php__ - Markup for the 404 page
  - __base.php__ - Wrapper framework around all pages of the site
  - __index.php__ - Blog markup and the default markup for any cpt archive pages unless an archive-cpt.php file is created instead
  - __page.php__ - Default page template
  - __search.php__ - Search results markup
  - __single.php__ - Single post type template
  - __functions.php__ - This file includes all custom PHP function files for the theme. Do not add functions here - look in __/lib/custom__ instead.

### /_templates
  - This contains the templates used when generating a new component, CSS file, or JavaScript file
  - for help on generating files run any of the following commands
    - `hygen component help`
    - `hygen cpt help`
    - `hygen css help`
    - `hygen js help`

### /acf-json
  - Automatically created .json files associated with the Advanced Custom Fields plugin. This ensures custom field groups are automatically synced between environments without a need to export/import field groups that have changed.

### /assets
  - __mix-manifest.json__ - Reference to the current version of the minified asset files to use
#### /assets/css
  - __main.min.css__ - Compiled file including all custom CSS and vendor CSS
  - __admin.min.css__ - Compiled file including all custom CSS for the admin side
  - __editor-style.css__ - Compiled file including all custom CSS for the WYSIWYG editor
  - __*.min.css.map__ - Generated file to map the location of CSS styles
  - __ajax-loader.gif__ - Loader gif for slick slider
  - __/fonts/slick.*__ - Fonts for slick slider

#### /assets/img
  - __symbol-defs.svg__ - Symbol definitions for SVG icon picker
  - __symbol-defs-ui.svg__ - Symbol definitions for SVG icons not being used in the icon picker
  - `<svg class="icon icon-namegoeshere"><use xlink:href="#icon-namegoeshere"></use></svg>`
  - __map-pin.png__ - Pin image used for map component

#### /assets/js
  - __scripts.min.js__ - Compiled file including all custom JS
  - __vendor.min.js__ - Compiled file including all custom JS
  - __admin.min.js__ - WordPress Admin-specific JavaScript
  - __*.min.js.map__ - Map files for compiled JS

### /components
  - This folder contains components that can be used throughout the site
  - Create new component: `hygen component new --name "Component Name"`
  - This would create a new component and it's own PHP, JS, and CSS files in  __/components/component-name__
  - When generating a new component, the JS and CSS are automatically included and compiled
  - Call the component:
  ```
  <?php
  include_component(
    'component-name',
    [
      'parameter' => value,
    ],
    [
      'classes' => ['']
      'id' => ''
    ]
  );
  ```

### /lib
  - __init.php__ - Initialize widgets, menus, and theme support activation
  - __nav.php__ - Custom Nav walker - remove?
  - __scripts.php__ - Enqueue and register various scripts

#### /lib/cpt
  - __cpt-name__ - Register custom post type
  - __main.php__ - Include CPT files in runtime

#### /lib/custom
  - Contains custom function files
  - All of these function files are included in the root __functions.php__ file
  - Do not write functions in __functions.php__, add functions to the appropriate file in these folders (or add you own new file and require it in __/lib/custom/main.php__)

#### /lib/Menu
  - Classes for our custom version of the nav walker

#### /lib/Router
  - __routes.php__ - Register api routes for use with AJAX calls
  - __Middleware.php__ - Class with functions to specify who can access a route created in routes.php

#### /lib/Wysiwyg
  - __Wysiwyg.php__ - Registers custom styles and plugins for the WYSIWYG editor
  - __formats/*.php__ - WYSIWYG formats
  - __plugins/*/*.js__ - JavaScript plugin code

#### /lib/metabox
  - Custom functions for advanced custom fields

#### /lib/plugins
  - Zip files of plugins that we require or always use with our theme
  - Advanced Custom Fields Pro - v6.0.4
  - Classic Editor - v1.6.2
  - Gravity Forms - v2.6.8.1

#### /lib/roots
  - Contains custom functions specific to the theme

#### /lib/tgm
  - Used to require and initiate the installation of plugins in the theme

### /resources

#### /resource/admin
  - __admin.css__ - Admin styles
  - __admin.js__ - Admin JS, consists mostly of scripts to customize acf and WYSIWYG functionalities
  - __editor-style.css__ - Extra styles for the WYSIWYG editor

#### /resource/css
  - __app.css__ - All CSS files must be imported here to be compiled, excluding files being added using import-glob such as partials, pages, and components
  - __tailwind.config.js__ - Configuration for custom styles for tailwind

##### /resource/css/base
  - Base styles, and typography

##### /resource/css/pages
  - Page-specific styles

##### /resource/css/partials
  - Styles that don't quite fit in components or specific pages, often on pieces that are shared across the theme

#### /resource/js
  - ___animations.js__ - Global site animations
  - ___blog.js__ - JavaScript for the copy functionality of the blog share links
  - ___common.js__ - JavaScript that is run globally
  - ___modal.js__ - Magnific Popup modal component
  - ___app.js__ - JavaScript to register components on the page and run the correct JavaScript
  - JavaScript components are included when needed by adding a data attribute on the page that it is required.
  - EX: `<button class="js-init-popup" data-modal="#popup-id" data-component="modal">Open popup</button>`

##### /resource/js/vendor
  - Vendor files not included via the package.json

### /templates
  - __template-name__ - Create templates in this directory
  - __template-basic.php__ - Basic WYSIWYG template

#### /templates/contents
  - __content-single.php__ - Content for single.php
  - __content.php__ - blog card markup

#### /templates/partials
  - __blog-sidebar.php__ - Blog sidebar
  - __comments.php__ - Markup for comments
  - __components.php__ - Registers components to be used on pages
  - __footer.php__ - Site wide footer
  - __form-search.php__ - Search form markup - can be called using `get_search_form()`
  - __head.php__ - Site wide head element
  - __header.php__ - Site wide header
  - __password-form.php__ - Password form markup, used when pages get password protected

## Using components.php
  - Using this will allow you to never have to step foot inside your components.php file again, unless you really want to. If you name your component field name in your flexible content ACF field group the same as your actual component's slug (except with underscores instead of dashes), then it will automatically get the component and the ACF fields.
  - Let's say we've got a Left Right component. We generate the files with our `hygen component new --name "Left Right"` task, which will then name the component `left-right`. In our flexible content field group, we'll give it the field name `left_right`, as usual. This new components.php file will then find the component with that name, replacing underscores with dashes.
  - We will want to name our component fields very similar to what the parameter names (ex. `$component_data['content']`) for the component are. Let's say in Left Right, we have a field for "Content" that is WYSIWYG field. The field name will need to be `"left_right_content"`. Breaking that down, it is `{component_name}_{parameter_name}`.

### Form ID Select Field
  - Create a select field and make sure the Field Name contains `form_id`

### Form Skin Radio Style
  - In the form editor of your ```.form-skin``` form, create a radio button. Select that field, and open the "Appearance" tab. You will see a "Radio Style" field, which will allow you to choose between normal radio styles, and button-ized radio buttons.

### SVG Icon Picker
  - This field will populate with the svg's found in the symbol-defs.svg
  - Create a clone field
  - In Fields search for and select `All fields from Utility : Icon Field field group`
  - If this field is not being used in a repeater or a group, make sure to turn the `Prefix Field Names` option on and have the Field Name contain your component name e.g `content_grid`

### WYSIWYG Background Colors
  - You can either clone the Utility : Background Color field group or create your own field group depending on your situation
  - Clone the Utility : Background Color field group
    - Create a clone field
    - In Fields search for and select `All fields from Utility : Background Color field group`
    - If this field is not being used in a repeater or a group, make sure to turn the `Prefix Field Names` option on and have the Field Name contain your component name e.g `content_grid`
  - Create a field group
    - Create a field with `_background_color` in the field name
    - Select a field type that has options. (Button Group, Select, Radio Button) Set the options for the field to have values that match your background color tailwind classes e.g. `bg-black : Black`
  - The WYSIWYG fields should automatically inherit the classes set for the chosen option
    - If the styles are not showing up you may have to whitelist them in your tailwind config, add them to the admin.css, or investigate further
    - If you need a WYSIWYG to only have a single background color, you can add the background color class to the Presentation > Wrapper Attributes > class option of the WYSIWYG field

### Heading Field
  - This field will provide the ability to set the heading level along with text for seo purposes
  - Create a clone field
  - In Fields search for and select `All fields from Utility : Heading field group`
  - If this field is not being used in a repeater or a group, make sure to turn the `Prefix Field Names` option on and have the Field Name contain your component name e.g `content_grid`
    - If you have multiple headings in one field group, make sure to turn the `Prefix Field Labels` option on and have the Field Label contain a description such as `Sub`, `Small`, `Main`, etc. and update the Field Name as well to contain your prefix e.g. `content_grid_small`
  - To display this field use the following markup
  ```
  <?php
    $heading = $component_data['heading'];
  ?>
  <?php if ( !empty($heading['text']) ) : ?>
    <<?php echo $heading['tag']; ?> class=""><?php echo $heading['text']; ?></<?php echo $heading['tag']; ?>>
  <?php endif; ?>
  ```

### Image Field
  - For use with the fit image component
  - Create a clone field
  - In Fields search for and select `All fields from Utility : Image field group`
  - If this field is not being used in a repeater or a group, make sure to turn the `Prefix Field Names` option on and have the Field Name contain your component name e.g `content_grid`
    - If you have multiple images in one field group, make sure to turn the `Prefix Field Labels` option on and have the Field Label contain a description such as `Small`, `Second`, `Large`, etc. and update the Field Name as well to contain your prefix e.g. `content_grid_small`
  - For easier use set Display from `Seamless` to `Group`
  - To display this field use the following markup for either `Seamless` or `Group` based on your field set up
  - `loading` field  allows you to set whether the image will be lazy loaded or not. Default is set to have lazy loading turned on. It is recommended to set any image above the fold of the initial page load to NOT be lazy loaded. e.g. ` 'loading' => 'eager' `
  ```
  <?php
    // Group
    $image = $component_data['image'];

    // Seamless
    $image_id = $component_data['image_id'];
    $position = $component_data['image_focus_point'];
    $fit = $component_data['image_fit'];
    $loading = $component_data['image_loading'];
  ?>
  <?php
    // Group
    include_component(
      'fit-image',
      array(
        'image_id' => $image['image_id'],
        'position' => $image['image_focus_point'],
        'fit' =>  $image['image_fit'],
        'loading' => $image['image_loading']
      )
    );

    // Seamless
    include_component(
      'fit-image',
      array(
        'image_id' => $image_id,
        'position' => $position,
        'fit' =>  $fit,
        'loading' => $loading
      )
    );
  ?>
  ```


