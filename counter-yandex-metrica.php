<?php
/*
Plugin Name: Yandex.Metrica Counter
Plugin URI: http://semikashev.com/wordpress/plugin-yametrika-counter
Description: Easy installation of counter Yandex.Metrica. Support Webvisor 2.0.
Version: 1.4.3

Author: Alexander Semikashev
Author URI: http://semikashev.com

Text Domain: counter-yandex-metrica
Domain Path: /languages

License: GPLv2 (or later)
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'YMC__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'YMC__BASENAME', plugin_basename(__FILE__) );
define( 'YMC__VERSION', '1.4.3' );

require_once( YMC__PLUGIN_DIR . 'class.ymc.php' );

add_action( 'init', array( 'YMC', 'init' ) );

require_once( YMC__PLUGIN_DIR . 'class.ymc-widget.php' );

if( is_admin() ){
    require_once( YMC__PLUGIN_DIR . 'class.ymc-admin.php' );
    add_action( 'init', array( 'YMC_Admin', 'init' ) );
}