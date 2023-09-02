<?php

class Leaderboard_Widget extends WP_Widget {

	/**
	 * Constructs the new widget.
	 * @see WP_Widget::__construct()
	 */
	function __construct() {
		// Instantiate the parent object.
		parent::__construct( false, __( 'Leaderboard Widget', 'textdomain' ) );
	}

	/**
	 * The widget's HTML output.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Display arguments including before_title, after_title,
	 *                        before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget.
	 */
	function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		echo $args['after_widget'];

		$attr = array(
			'table_stats' => 'challenges-won',
			'table_time' => 'all-time',
			'sl_all' => '340191457471889409',
			'game_list' => '',
		);
		$service = new Sl_Repository();
		$query_results = $service->fetch_with_parameters($instance);

		if (array_key_exists('errors', $query_results) == true)
		{
			$output = '<p>No Service</p>';
			return $output;
		}

		require ('views/sl-public-widget-display.php');
	}

	/**
	 * The widget update handler.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance The new instance of the widget.
	 * @param array $old_instance The old instance of the widget.
	 * @return array The updated instance of the widget.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['table_stats'] = $new_instance['table_stats'];
		$instance['table_time'] = $new_instance['table_time'];
		$instance['num_rows'] = $new_instance['num_rows'];
		$instance['sl_all'] = $new_instance['sl_all'];
		$instance['game_list[]'] = $new_instance['game_list'];

		return $instance;
	}

	/**
	 * Output the admin widget options form HTML.
	 *
	 * @param array $instance The current widget settings.
	 * @return string The HTML markup for the form.
	 */
	function form( $instance ) {
		$service = new Sl_Repository();
		$games = $service->fetch_active_games_list();

		require ('views/sl-admin-widget-display.php');
	}

}
