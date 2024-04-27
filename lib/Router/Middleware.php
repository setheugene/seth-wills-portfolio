<?php

class Middleware {

  private static $instance;

  public static function getInstance()
  {
    if ( is_null( self::$instance ) )
    {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function open()
  {
    return true;
  }
}
