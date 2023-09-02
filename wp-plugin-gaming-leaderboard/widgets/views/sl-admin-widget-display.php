<div class="wrap">
<p>
  <label>Witch stat type you want do display ? </label>
	<select type="text" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'table_stats' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'table_stats' ) ); ?>">
		<option value="<?php echo $instance['table_stats'] ; ?>" selected><?php echo $instance['table_stats'] ; ?></option>
		<option value="challenges-won">Wins</option>
		<option value="challenges-lost">Loses</option>
		<option value="win-loss-ratio">Win Lose Ratio</option>
	</select>
</p>
	<p>
	<label>Witch time period </label>
	<select type="text" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'table_time' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'table_time' ) ); ?>">
		<option value="<?php echo $instance['table_time'] ; ?>" selected><?php echo $instance['table_time'] ; ?> </option>
		<option value="day">Day </option>
		<option value="week">Week</option>
		<option value="month">Month</option>
		<option value="all-time">All time</option>
	</select>
</p>

<p>
	<label for="num_rows">Number of rows: </label>
	<select type="num" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'num_rows' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'num_rows' ) ); ?>">
		<option value="<?php echo $instance['num_rows'] ; ?>" selected> <?php echo $instance['num_rows'] ; ?></option>
		<?php
		for ($i = 1; $i <= 50; $i++){
			?>
			<option value="<?php echo $i ?>" type="num">
				<?php echo $i ?>
			</option>

			<?php
		}
		?>
	</select>
</p>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_name( 'game_list[all]') ); ?>">All Games</label>
		<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'game_list[all]') ); ?>" type="checkbox">
	</p>
		<?php foreach ($games as $game) {?>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_name( 'game_list[]') ); ?>" ><?php echo $game->game_name ?></label>
		<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'game_list[]') ); ?>" type="checkbox" value="<?php echo $game->game_id ?>">
	</p>
	<?php } ?>
</div>
