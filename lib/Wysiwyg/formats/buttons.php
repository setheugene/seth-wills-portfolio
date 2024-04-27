<?php

Wysiwyg()->add_format( array(
  'title' => 'Buttons & Links',
  'items' => array(
    array(
      'title'    => 'Standard Button',
      'classes'  => 'btn',
      'selector' => 'a',
      'wrapper'  => false
    ),
    array(
      'title' => 'Button Group',
      'classes' => 'btn-group', // if changing class update line 15 of Wysiwyg>plugins>buttonGroup>plugin.js to include your new class(es)
      'wrapper' => true,
      'block' => 'div',
    )
  )
) );
