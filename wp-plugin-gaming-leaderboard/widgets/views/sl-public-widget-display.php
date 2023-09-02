<div class="wrap">
<ul class="leaderboard-widget" >
	<table>
		<tbody>
		<tr class="sl_table_head">
			<th class="nobr">#</th>
			<th class="nobr">Name</th>
			<th class="nobr">Score</th>
			<th class="nobr">Avatar</th>
		</tr>
		<?php
		$i = 0;
		foreach ($query_results as $player) {
			if ($i == $instance['num_rows']){
				break;
			}
			$i++;
			?>
			<tr>
				<td><?php echo $player->position ?></td>
				<td><?php echo $player->user_nickname ?></td>
				<td><?php echo $player->score ?></td>
				<td><img src=\"https://static-dev.com/user-avatars/\"<?php echo $player->user_avatar ?>></td>
			</tr>
			<?php
		}?>
		</tbody>
	</table>
</ul>
</div>
<!-- reset global post variable. After this point, we are back to the Main Query object -->
<?php wp_reset_postdata(); ?>
