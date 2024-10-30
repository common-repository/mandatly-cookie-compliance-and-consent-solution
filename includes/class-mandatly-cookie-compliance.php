<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.mandatly.com
 *
 * @package    Mandatly_Cookie_Compliance
 * @subpackage Mandatly_Cookie_Compliance/includes
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
 * @package    Mandatly_Cookie_Compliance
 * @subpackage Mandatly_Cookie_Compliance/includes
 * @author     Mandatly Inc. <supportmail@mandatly.com>
 */
class Mandatly_Cookie_Compliance {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @access   protected
	 * @var      Mandatly_Cookie_Compliance_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
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
	 */
	public function __construct() {
		if ( defined( 'MCC_PLUGIN_VERSION' ) ) {
			$this->version = MCC_PLUGIN_VERSION;
		} else {
			$this->version = '1.2.1';
		}
		$this->plugin_name = 'mandatly-cookie-compliance';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_plugin_load();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Mandatly_Cookie_Compliance_Loader. Orchestrates the hooks of the plugin.
	 * - Mandatly_Cookie_Compliance_i18n. Defines internationalization functionality.
	 * - Mandatly_Cookie_Compliance_Admin. Defines all hooks for the admin area.
	 * - Mandatly_Cookie_Compliance_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mandatly-cookie-compliance-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mandatly-cookie-compliance-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-mandatly-cookie-compliance-admin.php';
		$this->loader = new Mandatly_Cookie_Compliance_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Mandatly_Cookie_Compliance_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Mandatly_Cookie_Compliance_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Mandatly_Cookie_Compliance_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'mcc_set_cookie_menu' );
		$this->loader->add_action( 'wp_ajax_save_server_mode', $plugin_admin, 'save_server_mode' );
		$this->loader->add_action( 'wp_ajax_save_settings', $plugin_admin, 'save_banner_cookie_settings' );
		$this->loader->add_action( 'wp_ajax_getslider_status', $plugin_admin, 'banner_getslider_status' );
		$this->loader->add_action( 'wp_ajax_slider_status', $plugin_admin, 'banner_slider_status' );
		$this->loader->add_action( 'wp_head', $plugin_admin, 'banner_script_insert', 1 );
		$this->loader->add_action( 'wp_ajax_xhrLink', $plugin_admin, 'handleXhrLink' );

		remove_action( 'wp_head', 'wp_resource_hints', 2 );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 */
	public function run() {
		$this->loader->run();
	}
	/**
	 * Run the loader to read json file and update config values.
	 */
	public function define_plugin_load() {
		if ( false != get_option( 'mcc_banner_config' ) ) {
			$abanner_array_val = maybe_unserialize( get_option( 'mcc_banner_config' ) );
			if ( '' != $abanner_array_val['banner_guid'] || 'active' == $abanner_array_val['banner_status']) {
				if ( 'active' == $abanner_array_val['banner_status'] ) {
					$banner_status = 'true';
				} else {
					$banner_status = 'false';
				}
				update_option( 'mdt_cookie_demo_status', 'false' );
				update_option( 'mdt_cookie_banner_guid', $abanner_array_val['banner_guid'] );
				update_option( 'mdt_cookie_banner_status', $banner_status );
				delete_option( 'mcc_banner_config' );
			}
		} 

		$settings_api_url    = PLUGIN_URL . 'plugin-settings.json';
		$url_settings_array  = json_decode( file_get_contents( $settings_api_url ), true );
		$demo_api_url        = $url_settings_array['baseURL'] . $url_settings_array['demoSettingFileName'];
		$demo_settings_array = json_decode( file_get_contents( $demo_api_url ), true );
		$demobannerpath      = $url_settings_array['baseURL'] . $demo_settings_array['demoBannerPath'];
		update_option( 'mdt_cookie_demo_url', $demobannerpath );
		$livebannerpath = $url_settings_array['baseURL'] . $url_settings_array['bannerFolder'];
		update_option( 'mdt_cookie_live_url', $livebannerpath );

	}
	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Mandatly_Cookie_Compliance_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}


}
