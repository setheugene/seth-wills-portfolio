<?php
class Wysiwyg {
  private $formats = [];
  private $format_dir;
  private $plugin_dir;
  private $plugins = [];
  protected static $_instance = null;

  public static function instance() {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }

    return self::$_instance;
  }

  public function __construct() {
    $this->format_dir = plugin_dir_path( __FILE__ ) . 'formats';
    $this->plugin_dir = get_template_directory_uri() . '/lib/Wysiwyg/plugins/';
    $this::init();
  }

  public function init() {
    add_filter( 'mce_buttons_2', array( $this, 'new_button' ) );
    add_filter( 'tiny_mce_before_init', array( $this, 'before_init' ) );
    add_filter( 'mce_buttons', array( $this, 'add_plugin_buttons' ) );
    add_filter( 'mce_external_plugins', array( $this, 'register_plugins' ) );
  }

  /*
   * Hook into which buttons are availble in the Tiny MCE UI.
   */
  public function new_button( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
  }

  /*
   * Add formats to the style format dropdown
   */
  public function before_init( $data ) {
    $format_files = glob($this->format_dir.'/*.php');

    foreach ($format_files as $file) {
      include_once($file);
    }

    $data['style_formats'] = json_encode( Wysiwyg()->formats );
    return $data;
  }

  /*
   * Add new style format data
   */
  public function add_format( $data ) {
    $this->formats[] = $data;
  }

  /*
   * Register new buttons for plugins
   */
  public function add_plugin_buttons( $buttons ) {
    array_push( $buttons, 'anchor' );
    array_push( $buttons, 'table' );
    return $buttons;
  }

  /*
   * Register  all new plugins to be used
   */
  public function register_plugins( $plugins ) {
    $this->plugins = $plugins;

    $this->register( 'anchor' );
    $this->register( 'table' );
    $this->register( 'remove_figure' );
    $this->register( 'blockcolor', 'wysiwyg_background_color' );
    $this->register( 'buttonGroup' );
    $this->register( 'custom_styles' );

    return $this->plugins;
  }

  /*
   * Register new plugin
   */
  private function register( $key, $path=false ) {
    if ( $path ) {
      $this->plugins[ $key ] = $this->plugin_dir . $path.'/plugin.js';
    } else {
      $this->plugins[ $key ] = $this->plugin_dir . $key.'/plugin.js';
    }
  }
}

/**
 * Allow custom classes to be applied to
 * WYSIWYG fields for editing editor.css
 */
function acf_admin_footer() {
  ?>
  <script>
    ( function( $) {
      acf.add_filter( 'wysiwyg_tinymce_settings', function( mceInit, id, $field ) {
        mceInit.body_class += ' ' + $field[0].classList;
        return mceInit;
      });
    })( jQuery );
  </script>
<?php
}
add_action('acf/input/admin_footer', 'acf_admin_footer');

/*
 * Initialize Wysiwyg to construct hooks
 * on admin_init
 */
add_action('admin_init', function() {
  Wysiwyg();
} );

/*
 * Setup instance function to reference
 * object later
 */
function Wysiwyg() {
  return Wysiwyg::instance();
}


