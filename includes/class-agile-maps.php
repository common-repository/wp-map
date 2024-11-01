<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://agilelogix.com
 * @since      1.0.0
 *
 * @package    AgileMaps
 * @subpackage AgileMaps/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    AgileMaps
 * @subpackage AgileMaps/includes
 * @author     Your Name <email@agilelogix.com>
 */
class AgileMaps {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      AgileMaps_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $AgileMaps    The string used to uniquely identify this plugin.
	 */
	protected $AgileMaps;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->AgileMaps = 'agile-maps';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		
		$this->plugin_admin = new AgileMaps_Admin( $this->get_AgileMaps(), $this->get_version() );
		
		//FRONTEND HOOOKS
		$this->plugin_public = new AgileMaps_Public( $this->get_AgileMaps(), $this->get_version() );
		add_action('wp_ajax_amaps_load_locations', array($this->plugin_public, 'load_locations'));	
		add_action('wp_ajax_nopriv_amaps_load_locations', array($this->plugin_public, 'load_locations'));

		add_action('wp_ajax_amaps_search_log', array($this->plugin_public, 'search_log'));	
		add_action('wp_ajax_nopriv_amaps_search_log', array($this->plugin_public, 'search_log'));	


		if (is_admin())
			$this->define_admin_hooks();
		else
			$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - AgileMaps_Loader. Orchestrates the hooks of the plugin.
	 * - AgileMaps_i18n. Defines internationalization functionality.
	 * - AgileMaps_Admin. Defines all hooks for the admin area.
	 * - AgileMaps_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once AGILE_MAPS_PLUGIN_PATH . 'includes/class-agile-maps-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once AGILE_MAPS_PLUGIN_PATH . 'includes/class-agile-maps-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once AGILE_MAPS_PLUGIN_PATH . 'admin/class-agile-maps-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once AGILE_MAPS_PLUGIN_PATH . 'public/class-agile-maps-public.php';

		$this->loader = new AgileMaps_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the AgileMaps_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new AgileMaps_i18n();
		$plugin_i18n->set_domain( $this->get_AgileMaps() );

		//$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

		add_action( 'plugins_loaded', array($this, 'load_plugin_textdomain') );
		//$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	public function load_plugin_textdomain() {


		$domain = 'agile_maps';

		$mo_file = WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . get_locale() . '.mo';

		//$mo_file = AGILE_MAPS_PLUGIN_PATH. $domain . '-' . get_locale() . '.mo';
	 	//dd(AGILE_MAPS_PLUGIN_PATH . 'languages/');

		
		load_textdomain( $domain, $mo_file ); 
		load_plugin_textdomain( $domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

	
		//ad menu if u r an admin
		add_action('admin_menu', array($this,'add_admin_menu'));
		add_action('wp_ajax_amaps_upload_marker', array($this->plugin_admin, 'upload_marker'));	
		/*For locations*/
		add_action('wp_ajax_amaps_add_location', array($this->plugin_admin, 'add_new_location'));	
		add_action('wp_ajax_amaps_delete_all_locations', array($this->plugin_admin, 'admin_delete_all_locations'));	
		add_action('wp_ajax_amaps_edit_location', array($this->plugin_admin, 'update_location'));	
		add_action('wp_ajax_amaps_get_location_list', array($this->plugin_admin, 'get_location_list'));	
		add_action('wp_ajax_amaps_delete_location', array($this->plugin_admin, 'delete_location'));	
		add_action('wp_ajax_amaps_duplicate_location', array($this->plugin_admin, 'duplicate_location'));	
		/*Categories*/
		add_action('wp_ajax_amaps_add_categories', array($this->plugin_admin, 'add_category'));
		add_action('wp_ajax_amaps_delete_category', array($this->plugin_admin, 'delete_category'));
		add_action('wp_ajax_amaps_update_category', array($this->plugin_admin, 'update_category'));
		add_action('wp_ajax_amaps_get_category_byid', array($this->plugin_admin, 'get_category_by_id'));
		add_action('wp_ajax_amaps_get_categories', array($this->plugin_admin, 'get_categories'));	

		/*Markers*/
		add_action('wp_ajax_amaps_add_markers', array($this->plugin_admin, 'add_marker'));
		add_action('wp_ajax_amaps_delete_marker', array($this->plugin_admin, 'delete_marker'));
		add_action('wp_ajax_amaps_update_marker', array($this->plugin_admin, 'update_marker'));
		add_action('wp_ajax_amaps_get_marker_byid', array($this->plugin_admin, 'get_marker_by_id'));
		add_action('wp_ajax_amaps_get_markers', array($this->plugin_admin, 'get_markers'));	

		/*Import and settings*/
		add_action('wp_ajax_amaps_save_setting', array($this->plugin_admin, 'save_setting'));

		//dashboard
		add_action('wp_ajax_amaps_save_setting', array($this->plugin_admin, 'save_setting'));		

		add_action('wp_ajax_amaps_get_stats', array($this->plugin_admin, 'get_stat_by_month'));



		$this->loader->add_action( 'admin_enqueue_scripts', $this->plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $this->plugin_admin, 'enqueue_scripts' );

	}

	/*All Admin Callbacks*/
	public function add_admin_menu() {

		if (current_user_can('delete_posts')){

			$svg = 'dashicons-location';
			add_Menu_page('Agile Maps', 'WP Maps', 'delete_posts', 'amaps-plugin', array($this->plugin_admin,'admin_plugin_settings'),$svg);
			add_submenu_page( 'amaps-plugin', 'Dashboard', 'Dashboard', 'delete_posts', 'amaps-dashboard', array($this->plugin_admin,'admin_dashboard'));
			add_submenu_page( 'amaps-plugin', 'New Location', 'New Location', 'delete_posts', 'create-amaps', array($this->plugin_admin,'admin_add_new_location'));
			add_submenu_page( 'amaps-plugin', 'Manage Markers', 'Manage Markers', 'delete_posts', 'manage-amaps-markers', array($this->plugin_admin,'admin_location_markers'));
			add_submenu_page( 'amaps-plugin', 'Manage Location', 'Manage Location', 'delete_posts', 'manage-amaps-location', array($this->plugin_admin,'admin_manage_location'));
			add_submenu_page( 'amaps-plugin', 'Manage Categories', 'Manage Categories', 'delete_posts', 'manage-amaps-categories', array($this->plugin_admin,'admin_manage_categories'));
			
			
			add_submenu_page( 'amaps-plugin', 'Settings', 'Settings', 'delete_posts', 'amaps-user-settings', array($this->plugin_admin,'admin_user_settings'));
			
			add_submenu_page('amaps-plugin-edit', 'Edit Location', 'Edit Location', 'delete_posts', 'edit-amaps-location', array($this->plugin_admin,'edit_location'));
			remove_submenu_page( "amaps-plugin", "amaps-plugin" );
			remove_submenu_page( "amaps-plugin", "amaps-plugin-edit" );
        }
	}

	/*Frontend of Plugin*/
	public function renderOutput($atts)
	{
		
		global $wpdb;

		$query   = "SELECT * FROM ".AGILE_MAPS_PREFIX."configs";
		$configs = $wpdb->get_results($query);

		$all_configs = array();
		
		foreach($configs as $_config)
			$all_configs[$_config->key] = $_config->value;

		$all_configs['URL'] = AGILE_MAPS_URL_PATH;
		

		//Get the categories
		$all_categories = array();
		$results = $wpdb->get_results("SELECT id,category_name as name,icon FROM ".AGILE_MAPS_PREFIX."categories WHERE is_active = 1");

		foreach($results as $_result)
		{
			$all_categories[$_result->id] = $_result;
		}


		//Get the Markers
		$all_markers = array();
		$results = $wpdb->get_results("SELECT id,marker_name as name,icon FROM ".AGILE_MAPS_PREFIX."markers WHERE is_active = 1");

		foreach($results as $_result)
		{
			$all_markers[$_result->id] = $_result;
		}

		/*
		$all_configs = shortcode_atts( $all_configs, $atts );

		if(isset($atts['category'])) {

			$all_configs['category'] = $atts['category'];
		}
		*/

		
		ob_start();
		
		include 'output-template.php';

		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$this->loader->add_action( 'wp_enqueue_scripts', $this->plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $this->plugin_public, 'enqueue_scripts' );
		

        add_shortcode( 'wp-map',array($this,'renderOutput'));	
	}

	
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_AgileMaps() {
		return $this->AgileMaps;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    AgileMaps_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
