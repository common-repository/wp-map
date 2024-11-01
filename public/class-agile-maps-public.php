<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://agilelogix.com
 * @since      1.0.0
 *
 * @package    AgileMaps
 * @subpackage AgileMaps/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    AgileMaps
 * @subpackage AgileMaps/public
 * @author     Your Name <email@agilelogix.com>
 */
class AgileMaps_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $AgileMaps    The ID of this plugin.
	 */
	private $AgileMaps;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $AgileMaps       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $AgileMaps, $version ) {

		$this->AgileMaps = $AgileMaps;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in AgileMaps_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The AgileMaps_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		
		wp_enqueue_style( $this->AgileMaps,  AGILE_MAPS_URL_PATH.'public/css/agile-maps-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in AgileMaps_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The AgileMaps_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$title_nonce = wp_create_nonce( 'amaps_remote_nonce' );
		
		
		global $wp_scripts,$wpdb;

		$sql = "SELECT `key`,`value` FROM ".AGILE_MAPS_PREFIX."configs WHERE `key` = 'api_key'";
		$all_result = $wpdb->get_results($sql);
		

		//$map_url = '//maps.googleapis.com/maps/api/js?sensor=false&libraries=geometry,places';
		$map_url = '//maps.googleapis.com/maps/api/js?libraries=places,drawing';

		if($all_result[0] && $all_result[0]->value) {
			$api_key = $all_result[0]->value;

			$map_url .= '&key='.$api_key;
		}

		//dd(get_locale());
		
		//dd($wp_scripts->registered);
		wp_enqueue_script('google-map', $map_url );
		wp_enqueue_script( $this->AgileMaps.'-lib', AGILE_MAPS_URL_PATH . 'public/js/all_libs.min.js', array('jquery'), $this->version, false );
		wp_enqueue_script( $this->AgileMaps.'-script', AGILE_MAPS_URL_PATH . 'public/js/amap-script.js', array('jquery'), $this->version, false );
		wp_localize_script( $this->AgileMaps.'-script', 'AGILE_MAPS_REMOTE', array(
		    'ajax_url' => admin_url( 'admin-ajax.php' ),
		    'nonce'    => $title_nonce, // It is common practice to comma after
		    'URL' => AGILE_MAPS_URL_PATH
		) );
	}

	public function search_log()
	{

		global $wpdb;
		
		$nonce = isset($_GET['nonce'])?$_GET['nonce']:null;
		/*
		if ( ! wp_verify_nonce( $nonce, 'amaps_remote_nonce' ))
 			die ( 'CRF check error.');
 		*/

 		if(!isset($_POST['is_search'])) {
 			die ( 'CRF check error.');
 		}

		$is_search 	  = ($_POST['is_search'] == '1')?1:0;
		$ip_address   = $_SERVER['REMOTE_ADDR'];


		$AGILE_MAPS_PREFIX = AGILE_MAPS_PREFIX;

		if($is_search == 1) {
			
			$search_str   = $_POST['search_str'];
			$place_id     = $_POST['place_id'];

			//To avoid multiple creations
			$count = $wpdb->get_results( $wpdb->prepare( "SELECT COUNT(*) AS c FROM `{$AGILE_MAPS_PREFIX}locations_view` WHERE (created_on > NOW() - INTERVAL 15 MINUTE) AND place_id = %s",
				$place_id
			));

			if($count[0]->c < 1) {

				$wpdb->query( $wpdb->prepare( "INSERT INTO {$AGILE_MAPS_PREFIX}locations_view (search_str, place_id, is_search, ip_address ) VALUES ( %s, %s, %d, %s )", 
			    	$search_str, $place_id, $is_search ,$ip_address 
				));
			}
		}
		else {

			$location_id   = $_POST['location_id'];

			//To avoid multiple creations
			$count = $wpdb->get_results( $wpdb->prepare( "SELECT COUNT(*) AS c FROM `{$AGILE_MAPS_PREFIX}locations_view` WHERE (created_on > NOW() - INTERVAL 15 MINUTE) AND location_id = %s",
				$location_id
			));

			if($count[0]->c < 1) {
				
				$wpdb->query( $wpdb->prepare( "INSERT INTO {$AGILE_MAPS_PREFIX}locations_view (location_id, is_search, ip_address ) VALUES ( %s, %d, %s )", 
			    	$location_id, $is_search ,$ip_address
				));
			}

		}

	
		echo die('[]');
	}

	public function load_locations()
	{
		//header('Content-Type: application/json');
		global $wpdb;
		
		$nonce = isset($_GET['nonce'])?$_GET['nonce']:null;
		/*
		if ( ! wp_verify_nonce( $nonce, 'amaps_remote_nonce' ))
 			die ( 'CRF check error.');
 		*/

		$AGILE_MAPS_PREFIX = AGILE_MAPS_PREFIX;


       	if($accordion && false) {

       		$country_field = " {$AGILE_MAPS_PREFIX}countries.`country`,";
       		$extra_sql = "LEFT JOIN {$AGILE_MAPS_PREFIX}countries ON s.`country` = {$AGILE_MAPS_PREFIX}countries.id";
       	}


       	$clause = '';

		$query   = "SELECT l.`id`, `title`,  `description`, `street`,  `city`,  `state`, `postal_code`, {$country_field} `lat`,`lng`,`phone`,  `fax`,`email`,`website`,`logo_id`,`marker_id`,`description_2`,
					group_concat(category_id) as categories FROM {$AGILE_MAPS_PREFIX}locations as l
					LEFT JOIN {$AGILE_MAPS_PREFIX}locations_categories c ON l.`id` = c.location_id
					WHERE (is_disabled is NULL || is_disabled = 0) 
					GROUP BY l.`id` ORDER BY `title`";

		$query .= " LIMIT 1000";

		$all_results = $wpdb->get_results($query);
		

		echo json_encode($all_results);die;
	}

}
