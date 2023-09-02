<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @since      1.0.0
 *
 * @package    Sl
 * @subpackage Sl/includes
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
 * @package    Sl
 * @subpackage Sl/includes
 */

class Sl {
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Sl_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

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
		if ( defined( 'SL_VERSION' ) ) {
			$this->version = SL_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'sl';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		add_shortcode('leaderboard', array($this, 'generate_inital_leaderboard_table'), $priority = 10, $accepted_args = 2);
		add_shortcode('leaderboard-custom', array($this, 'shortcode_handler'));
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Sl_Loader. Orchestrates the hooks of the plugin.
	 * - Sl_i18n. Defines internationalization functionality.
	 * - Sl_Admin. Defines all hooks for the admin area.
	 * - Sl_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		/**
		 * Widget
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'widgets/class-sl-widget.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sl-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sl-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sl-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sl-public.php';

		/**
		 * 	The Widget class.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sl-public.php';

		/**
		 * 	The Service class
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sl-repository.php';


		$this->loader = new Sl_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Sl_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new Sl_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Sl_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_options_page' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_setting' );

		//Register Shortcode Generator
		$this->loader->add_action( 'admin_post_generate_shortcode', $plugin_admin, 'sl_generate_shortcode');

		//Register widgets
		$this->loader->add_action( 'widgets_init', $plugin_admin, 'register_widgets' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Sl_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'wp_ajax_update_frontend_data', $plugin_public , 'update_frontend_data' );
		$this->loader->add_action( 'wp_ajax_nopriv_update_frontend_data', $plugin_public , 'update_frontend_data' );
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
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Sl_Loader    Orchestrates the hooks of the plugin.
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

	/**
	 * Fetch challages
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function generate_inital_leaderboard_table()
	{
		ob_start();
		$key = get_option('leaderboard_api_key');
		$rows = get_option('leaderboard_num_rows');

		$initial_params = [
			'table_stats' => 'challenges-won',
			'table_time' => 'all-time',
			'games' => 'all',
			'game_list' => ',',
			'num_rows' => '10'
		];

		$repository = new Sl_Repository();
		$data = $repository->fetch_with_parameters($initial_params);
		$games = $repository->fetch_active_games_list();

		if (array_key_exists('errors', $data) == true)
		{
			$output = '<p>No Service</p>';
			return $output;
		}

		require_once plugin_dir_path(dirname(__FILE__)) . '/public/partials/sl-public-display.php';
		$output = ob_get_clean( );
		return $output;
	}


	/**
	 *	Parse shortcode and generate table
	 *
	 * @param $atts
	 * @param $content
	 * @param $tag
	 * @return string
	 * @since    1.0.0
	 * @access   public
	 */
	public function shortcode_handler($atts = [], $content = null, $tag = '')
	{
		$atts = shortcode_atts([
			'table_stats' => 'challenges-won',
			'table_time' => 'all-time',
			'games' => 'all',
			'game_list' => ',',
			'num_rows' => '10'
		], $atts, $tag);

		$slug = $atts['table_stats'].'-'.$atts['table_time'];

		$key = get_option('eaderboard_api_key');
		$rows = get_option('leaderboard_num_rows');

		$service = new Sl_Repository();
		$data = $service->fetch_with_parameters($atts);

		if (array_key_exists('errors', $data) == true)
		{
			$output = '<p>No Service</p>';
			return $output;
		}

		$output = '
		<div> 
		<table>
		<tr class="sl_table_head">
			<th class="nobr">#</th>
			<th class="nobr">Name</th>
			<th class="nobr">Score</th>
			<th class="nobr">Avatar</th>
		</tr>';
		$i = 0;
		foreach ($data as $player){
			$i++;
			if ($i > $rows){
				break;
			}

			$output .= "<tr>
			<td>$player->position</td>
			<td>$player->user_nickname</td>
			<td>$player->score</td>
			<td><img class=\"avatar\" src=\"https://static-dev.gams/user-avatars/$player->user_avatar\"></td>
		</tr>";

		}
		$output .= '</table></div>';
		return $output;
	}
}
