<?php
/*
 * Plugin Name: Zurb Foundation 5 Clearing Gallery
 * Plugin URI: 
 * Description: Enhance Wordpress gallery shortcode with the Zurb Foundation Clearing lightbox.
 * Author: Benjamin Moody
 * Version: 1.01
 * Author URI: http://www.benjaminmoody.com
 * License: GPL2+
 * Text Domain: prso_foundation_5_gallery_plugin
 * Domain Path: /languages/
 */

//Define plugin constants
define( 'PRSOFOUNDATION5GALLERY__MINIMUM_WP_VERSION', '3.0' );
define( 'PRSOFOUNDATION5GALLERY__VERSION', '1.01' );
define( 'PRSOFOUNDATION5GALLERY__DOMAIN', 'prso_foundation_5_gallery_plugin' );

//Plugin admin options will be available in global var with this name, also is database slug for options
define( 'PRSOFOUNDATION5GALLERY__OPTIONS_NAME', 'prso_foundation_5_gallery_options' );

define( 'PRSOFOUNDATION5GALLERY__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PRSOFOUNDATION5GALLERY__PLUGIN_URL', plugin_dir_url( __FILE__ ) );

//Include plugin classes
require_once( PRSOFOUNDATION5GALLERY__PLUGIN_DIR . 'class.prso-foundation-5-clearing-gallery.php'               );

//Set Activation/Deactivation hooks
register_activation_hook( __FILE__, array( 'PrsoFoundation5Gallery', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'PrsoFoundation5Gallery', 'plugin_deactivation' ) );

//Set plugin config
$config_options = array();

//Instatiate plugin class and pass config options array
new PrsoFoundation5Gallery( $config_options );