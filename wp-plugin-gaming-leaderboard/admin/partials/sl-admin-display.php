<?php

/**
 * Provide a admin area views for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       a
 * @since      1.0.0
 *
 * @package    Sl
 * @subpackage Sl/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<form action="options.php" method="post">
		<?php
		settings_fields( $this->plugin_name );
		do_settings_sections( $this->plugin_name );
		submit_button();
		?>
	</form>
</div>

<div class="wrap">
	<h2>Generate your shortcode</h2>
	<form id="sl_form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
		<input type="hidden" name="action" value="generate_shortcode" />
		<label for="num_rows">Table Rows:</label>
		<input step="1" min="1" type="number" class="small-text" name="num_rows" required>
		<label for="table_stats">Table Stat:</label>
		<select id="sl_data_list" name="table_stats" required>
			<option value="challenges-won">Win</option>
			<option value="challenges-lost">Lose</option>
			<option value="win-loss-ratio">Win/Lose Ratio</option>
		</select>

		<label for="time_list">By:</label>
		<select id="sl_time_list" name="table_time" required>
			<option value="day">Day</option>
			<option value="week">Week</option>
			<option value="month">Month</option>
			<option value="all-time">All time</option>
		</select>
		<p>
			<label for="all_games_check">All Games</label>
			<input class="widefat" name="all_games_check" type="checkbox" checked>
		</p>
		<?php foreach ($games as $game) {?>
			<p>
				<label for="game_list[]" ><?php echo $game->game_name ?></label>
				<input class="widefat" name="game_list[]" type="checkbox" value="<?php echo $game->game_id ?>">
			</p>
		<?php } ?>
		<input type="submit" name="submit" id="submit" class="button button-primary" value="Submit Form"></p>
	</form>
	<br/>
	<br/>
	<div id="schortcode_display_box">
		<?php if (array_key_exists('custom_shortcode', $_GET)) { echo $_GET['custom_shortcode']; }else{ echo 'example shortcode: [leaderboard-custom table_stats=challenges-won table_time=day games=all numrows=10]'; }?>
	</div>
	<br/><br/>
</div>
<script>

</script>
