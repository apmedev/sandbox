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
	<form id="sl_form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="get">
		<input type="hidden" name="action" value="sl_generate_shortcode" />
		<label for="num_rows">Table Rows:</label>
		<input step="1" min="1" type="number" class="small-text" name="num_rows">
		<label for="data_list">Table Stat:</label>
		<select id="sl_data_list" name="data_list">
			<option value="challenges-won">Win</option>
			<option value="challenges-lost">Lose</option>
			<option value="win-loss-ratio">Win/Lose Ratio</option>
		</select>

		<label for="time_list">By:</label>
		<select id="sl_time_list" name="time_list">
			<option value="day">Day</option>
			<option value="week">Week</option>
			<option value="month">Month</option>
			<option value="all-time">All time</option>
		</select>
		<p>
			<label for="games_list[all]">All Games</label>
			<input class="widefat" name="game_list[all]" type="checkbox">
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
	<div id="schortcode_display_box"></div>
	<br/><br/>
</div>

