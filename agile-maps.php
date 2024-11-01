<?php

/**
 *
 * @link              https://agilelogix.com
 * @since             1.0.0
 * @package           AgileMaps
 *
 * @wordpress-plugin
 * Plugin Name:       Free Google Maps
 * Plugin URI:        https://wpmaps.com
 * Description:       Free Google Maps (Version 1.0.1) is a Wordpress Plugin that shows a beautiful Map on Page/Post.
 * Version:           1.0.1
 * Author:            AGILELOGIX
 * Author URI:        https://agilelogix.com/
 * License:           Copyrights 2018
 * License URI:       
 * Text Domain:       agile-maps
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/*
function d($d){echo '<pre>';print_r($d);echo '</pre><hr/>';}
function dd($d){echo '<pre>';print_r($d);echo '</pre>';die;}
*/


define( 'AGILE_MAPS_URL_PATH', plugin_dir_url( __FILE__ ) );
define( 'AGILE_MAPS_PLUGIN_PATH', plugin_dir_path(__FILE__) );
define( 'AGILE_MAPS_PREFIX', $wpdb->prefix."amaps_" );


global $wp_version;



if (version_compare($wp_version, '3.3.2', '<=')) {
	//die('version not supported');
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-agile-maps-activator.php
 */
function activate_AgileMaps() {
	require_once AGILE_MAPS_PLUGIN_PATH . 'includes/class-agile-maps-activator.php';
	AgileMaps_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-agile-maps-deactivator.php
 */
function deactivate_AgileMaps() {
	require_once AGILE_MAPS_PLUGIN_PATH . 'includes/class-agile-maps-deactivator.php';
	AgileMaps_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_AgileMaps' );
register_deactivation_hook( __FILE__, 'deactivate_AgileMaps' );



/*
function amaps_filter_mce_css( $mce_css ) {
	global $current_screen;
	
	if($current_screen->parent_base == 'amaps-plugin')
		$mce_css .= ', ' . plugins_url( 'public/css/blue/all-css.min.css', __FILE__ ).', ' .plugins_url( 'public/css/test2c0.css', __FILE__ );
	
	return $mce_css;
}
add_filter( 'mce_css', 'amaps_filter_mce_css' );

*/


 function amaps_filter_mce_css( $mce ) {
	global $current_screen;

	if($current_screen->parent_base == 'amaps-plugin') {
		$mce_css .= ', ' . plugins_url( 'public/css/all-css.min' . '.css', __FILE__ );
		$mce_css .= ', ' . plugins_url( 'public/css/blue/test2c0' . '.css', __FILE__ );
	}
	return $mce_css;
}
add_filter( 'mce_css', 'amaps_filter_mce_css' );







/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require AGILE_MAPS_PLUGIN_PATH . 'includes/class-agile-maps.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_AgileMaps() {

	$plugin = new AgileMaps();
	$plugin->run();
}

run_AgileMaps();
