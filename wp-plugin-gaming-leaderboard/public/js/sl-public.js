window.onload = function() {
	let request = new XMLHttpRequest();
	let btn = document.getElementById('sl_form_table_btn');
	let rows = document.getElementById('sl_form_table_btn');
	var base  ='https://ls/v2/rankings/public-v2/';

	rows = rows.value;
	document.getElementsByTagName('IMG').height = "100";

	btn.addEventListener('click', function(e) {
		e.preventDefault();

		let stat = document.getElementById('sl_data_list');
		stat = stat.options[stat.selectedIndex].value;

		let game = document.getElementById('sl_game_list');
		game = game.options[game.selectedIndex].value;

		let time = document.getElementById('sl_time_list');
		time = time.options[time.selectedIndex].value;

		if (time === 'all-time'){
			endpoint = base+stat+'-'+time;
		}else{
			endpoint = base+stat+'-by-'+time;
		}

		if (game !== 'any'){
			endpoint = endpoint + '?games='+ game;
		}

		jQuery.ajax({
			url: ajax_object.ajax_url,
			type: 'POST',
			data: {
				'action': 'update_frontend_data',
				'endpoint': endpoint,
			},
			success:function(data) {
				document.getElementById('sl_table_container').innerHTML = "";

				let responseObject = JSON.parse(data);
				var table = document.createElement('table');

				for( var i = 0; i < responseObject.length; i++ ) {
					if (i >= rows){
						break;
					}

					if (i == 0){
						var head_row = table.insertRow();
						head_row.className = "sl_table_head";
						cell_one = head_row.insertCell(0);
						cell_one.className = "nobr";
						cell_two = head_row.insertCell(1);
						cell_one.className = "nobr";
						cell_three = head_row.insertCell(2);
						cell_three.className = "nobr";
						cell_four = head_row.insertCell(3);
						cell_four.className = "nobr";
						cell_one.appendChild(document.createTextNode('#'));
						cell_two.appendChild(document.createTextNode('Name'));
						cell_three.appendChild(document.createTextNode('Score'));
						cell_four.appendChild(document.createTextNode('Avatar'));
					}

					var row = table.insertRow();
					var child = responseObject[i];

					Object.keys(child).forEach(function(k) {
						var cell = row.insertCell();
						if (k == "user_avatar"){
							var img = document.createElement('IMG');
							img.src = "https://static-dev.game/user-avatars/"+child.user_avatar;
							img.height = "50";
							img.width = "50";
							cell.appendChild(img);
							cell.className = "nobr";
						}else{
							cell.appendChild(document.createTextNode(child[k]));
						}
					});
				}

				document.getElementById('sl_table_container').appendChild(table);
			},
			error: function(errorThrown){
				console.log(errorThrown);
			}
		});
	});
};
