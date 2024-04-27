<?php

Wysiwyg()->add_format( array(
  'title'    => 'Body Text',
  'items'  => array(
    array(
      'title'    => 'Regular Paragraph : 16px',
      'classes'  => 'paragraph-default',
      'selector' => 'p, a, span, li, h1, h2, h3, h4, h5, h6',
      'wrapper'  => false
    ),
    array(
      'title'    => 'Large Paragraph Text : 18px',
      'classes'  => 'paragraph-large',
      'selector' => 'p, a, span, li, h1, h2, h3, h4, h5, h6',
      'wrapper'  => false
    ),
    array(
      'title'    => 'Small Paragraph Text : 14px',
      'classes'  => 'paragraph-small',
      'selector' => 'p, a, span, li, h1, h2, h3, h4, h5, h6',
      'wrapper'  => false
    ),
    array(
      'title'    => 'Extra Small Paragraph Text : 12px',
      'classes'  => 'paragraph-xsmall',
      'selector' => 'p, a, span, li, h1, h2, h3, h4, h5, h6',
      'wrapper'  => false
    )
  )
) );
