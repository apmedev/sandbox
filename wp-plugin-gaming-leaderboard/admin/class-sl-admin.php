<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Sl
 * @subpackage Sl/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sl
 * @subpackage Sl/admin
 */
class Sl_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The options name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'leaderboard';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sl_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sl_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sl-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sl_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sl_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sl-admin.js', array( ), $this->version, false );

	}

	/**
	 * Add an options page under the Settings submenu
	 *
	 * @since  1.0.0
	 */
	public function add_options_page() {
		$this->plugin_screen_hook_suffix = add_options_page(
			__( ' Leaderboard Settings', 'leaderboard' ),
			__( ' Leaderboard ', 'leaderboard' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);
	}

	/**
	 * Register all related settings of this plugin
	 *
	 * @since  1.0.0
	 */
	public function register_setting() {
		add_settings_section(
			$this->option_name . '_general',
			__( 'General', 'leaderboard' ),
			array( $this, $this->option_name . '_general_cb' ),
			$this->plugin_name
		);

		add_settings_field(
			$this->option_name . '_api_key',
			__( 'Your API Key', 'leaderboard' ),
			array( $this, $this->option_name . '_api_key_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_api_key' )
		);

		add_settings_field(
			$this->option_name . '_num_rows',
			__( 'Select the number of rows to be shown in the table', 'leaderboard' ),
			array( $this, $this->option_name . '_num_rows_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_num_rows' )
		);

		add_settings_field(
			$this->option_name . '_layout',
			__( 'Select the tabble layout', 'leaderboard' ),
			array( $this, $this->option_name . '_layout_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_layout' )
		);

		add_settings_field(
			$this->option_name . '_theme',
			__( 'Choose the plugin theme', 'leaderboard' ),
			array( $this, $this->option_name . '_theme_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_theme' )
		);


		add_settings_section(
			$this->option_name . '_shortcode_docs',
			__( 'Shortcode', 'leaderboard' ),
			array( $this, $this->option_name . '_shortcode_cb' ),
			$this->plugin_name
		);

		//@to do: Sanitize input
		register_setting( $this->plugin_name, $this->option_name.'_api_key', 'text');
		register_setting( $this->plugin_name, $this->option_name.'_num_rows', 'inval');
	}

	/**
	 * Create our custom filter widget
	 *
	 * @since    1.0.0
	 */
	public function register_widgets() {
		register_widget( 'Leaderboard_Widget' );
	}

	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
		$games = new Sl_Repository();
		$games = $games->fetch_active_games_list();

		include_once 'partials/sl-admin-display.php';
	}

	/**
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function leaderboard_general_cb() {
		echo '<p>' . __( 'Please change the settings accordingly.', 'leaderboard' ) . '</p>';
		echo  __( 'To output the plugin table use this shortcode: [eaderboard]', 'leaderboard' );

	}

	/**
	 * Render the api key input field
	 *
	 * @since  1.0.0
	 */
	public function leaderboard_api_key_cb() {
		$api = get_option( $this->option_name . '_api_key' );
		echo '<input class="regular-text code" type="text" name="' . $this->option_name . '_api_key' . '" id="' . $this->option_name . '_api_key' . '" value="' . $api . '"> ' . __( '', 'leaderboard' );
	}

	/**
	 * Render the right amount of rows for our table. Defined by the user.
	 *
	 * @since  1.0.0
	 */
	public function leaderboard_num_rows_cb() {
		$num = get_option( $this->option_name . '_num_rows' );
		echo '<input step="1" min="1" value="'.$num.'" type="number" class="small-text"  name="' . $this->option_name . '_num_rows' . '" id="' . $this->option_name . '_num_rows' . '" > ' . __( '', 'leaderboard' );
	}

	/**
	 *
	 *
	 * @since  1.0.0
	 */
	public function leaderboard_layout_cb() {
		echo '<select class="small-text"  name="' . $this->option_name . '_layout' . '" id="' . $this->option_name . '_layout' . '" > ' . __( '', 'leaderboard' );
		echo '<option value ="A">Filter on left side</option>';
		echo '<option value ="B">Filter on top</option>';
		echo '</select>';
	}

	/**
	 *
	 * @since  1.0.0
	 */
	public function leaderboard_theme_cb() {
		echo '<select class="small-text"  name="' . $this->option_name . '_theme' . '" id="' . $this->option_name . '_theme' . '" > ' . __( '', 'leaderboard' );
		echo '<option value ="dark">Dark</option>';
		echo '<option value ="light">Light</option>';
		echo '<option value ="Inherit">Inherit</option>';
		echo '</select>';
	}

	public function leaderboard_shortcode_cb() {
		echo  __( 'To output your custom table generate your shortcode: [leaderboard-custom table_stats=challenges-won table_time=day games=all numrows=10] </br>', 'leaderboard' );
	}


	public function sl_generate_shortcode(){
		$table_stats = $_REQUEST['table_stats'];
		$table_time = $_REQUEST['table_time'];
		$rows = $_REQUEST['num_rows'];

		$schortcode_base = 'leaderboard-custom';

		$response = $schortcode_base.' table_stats='.$table_stats.' table_time='.$table_time.' numrows='.$rows;

		if (array_key_exists('all_games_check', $_REQUEST)){
			$all = $_REQUEST['all_games_check'];

		}elseif (array_key_exists('game_list', $_REQUEST)){
			$game_list = $_REQUEST['game_list'];
			$response .= ' games_list=';
			foreach ($game_list as $game){
				$response .= $game.',';
			}
		}

		wp_redirect( home_url() .'/wp-admin/options-general.php?page=sl&custom_shortcode='.$response );
		exit;
	}

}
