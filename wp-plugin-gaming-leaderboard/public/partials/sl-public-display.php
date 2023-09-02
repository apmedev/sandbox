<?php
/**
 * Provide a public-facing views for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       a
 * @since      1.0.0
 *
 * @package    Sl
 * @subpackage Sl/public/partials
 */
//var_dump($games);
?>
<?php wp_reset_postdata(); ?>
<div class="wrap" id="sl-table-filter">
	<form id="sl_form">
		<label for="data_list">Filter:</label>
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
		<label for="game_list">Game:</label>
		<select id="sl_game_list" name="sl_game_list">
			<option value="any">Any</option>
			<?php foreach ($games as $game) {?>
				<option value="<?php echo $game->game_id ?>"><?php echo $game->game_name ?></option>
			<?php } ?>
		</select>
		<button id="sl_form_table_btn" value="<?php echo $rows ?>">
			Go
		</button>
	</form>
</div>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap" id="sl_table_container">
	<table id="sl_table">
		<tr class="sl_table_head">
			<th class="nobr">#</th>
			<th class="nobr">Name</th>
			<th class="nobr">Score</th>
			<th class="nobr">Avatar</th>
		</tr>
		<?php
		$i = 0;
		foreach ($data as $player){
			$i++;
			if ($i > $rows){
				break;
			}
			?>
			<tr>
				<td class="nobr"><?php echo $player->position ?></td>
				<td class="nobr"><?php echo $player->user_nickname ?></td>
				<td class="nobr"><?php echo $player->score ?></td>
				<td class="nobr"><img src="https://static-dev/user-avatars/"<?php echo $player->user_avatar ?>>
				</td>
			</tr>

			<?php
		}
		?>
	</table>
</div>
<?php wp_reset_postdata(); ?>
</div>
