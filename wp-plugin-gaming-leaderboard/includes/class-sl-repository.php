<?php

/**
 * Define the api data fetching functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       a
 * @since      1.0.0
 *
 * @package    Sl
 * @subpackage Sl/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Provides methods for fetching and organizing data got from our repository.
 *
 * @since      1.0.0
 * @package    Sl
 * @subpackage Sl/includes
 */
class Sl_Repository extends Sl {

	/**
	 * The Api token required for this plugin to access  services.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $token   The Api token of this plugin.
	 */
	private $token;

	/**
	 *  The base uri for  services.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $baseurl    The base uri for  services.
	 */
	private $baseUrl;

	/**
	 *  The uri for listing active games in .
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $baseurl    The url for  services - active games list.
	 */
	private $activeGamesUrl;

	/**
	 * The Request headers used by this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $headers    The Request headers used by this plugin.
	 */
	private $headers;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $token      The Api token of this plugin.
	 * @param      string    $baseurl    The base uri for  services.
	 * @param      array     $headers    The Request headers used by this plugin.
	 * @param      array     $activeGamesUrl    The Request headers used by this plugin.
	 */
	public function __construct()
	{
		$this->token = get_option('leaderboard_api_key');
		$this->baseUrl = 'https://ls-dev.com/v2/rankings/public-v2/';
		$this->headers = array(
			'headers'     => array(
				'Authorization' => 'Bearer '.$this->token ,
			),
		);
		$this->activeGamesUrl = "https://ls-dev.com/v2/active-games";
	}

	/**
	 * Fetch  active games list.
	 *
	 * @since    1.0.0
	 */
	public function fetch_active_games_list()
	{
		$result = wp_remote_get($this->activeGamesUrl, $this->headers);
		return json_decode($result['body']);
	}

	/**
	 * Fetch data by given params.
	 *
	 * @since    1.0.0
	 */
	public function fetch_with_parameters($params)
	{
		$stat = $params['table_stats'];
		$stat_time = $params['table_time'];

		//If games the games checkbox list is populated then
		if ($stat_time == "all-time"){
			$remote_url = $this->baseUrl.''.$stat.'-'.$stat_time;
		}else{
			$remote_url = $this->baseUrl.''.$stat.'-by-'.$stat_time;
		}

		//If specific games are selected
		if (array_key_exists('game_list', $params) && !empty($params['games_list'])){
			//Set url to support games list
			$games_list = $params['games_list'];
			$list = implode(',', $games_list);

			$remote_url .= '?games=' . $list;//print games list

			echo $remote_url;
		}elseif(array_key_exists('games', $params) && !empty($params['games'])){
			$games= $params['games'];
		}

		$result = wp_remote_get($remote_url, $this->headers);

		return json_decode($result['body']);
	}

	/**
	 * Fetch data by frontend generated endpoint.
	 *
	 * @since    1.0.0
	 */
	public function fetch_with_endpoint($endpoint)
	{
		$result = wp_remote_get( $endpoint, $this->headers);
		return $result['body'];
	}
}

