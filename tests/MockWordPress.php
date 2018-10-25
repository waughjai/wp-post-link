<?php
	const OBJECT = "";

	global $posts;
	$posts =
	[
		[ 'url' => 'https://www.jaimeson-waugh.com', 'title' => 'Jaimeson Waugh', 'slug' => 'jaimeson-waugh' ],
		[ 'url' => 'https://www.google.com',         'title' => 'Google'        , 'slug' => 'google'         ]
	];

	class WP_Post
	{
		public function __construct( $input )
		{
			global $posts;
			$this->ID = $input;
			$this->post_title = $posts[ $input ][ 'title' ];
		}

		public $ID;
		public $post_title;
	}

	function get_post( $input )
	{
		return new WP_Post( $input );
	}

	function get_permalink( $input )
	{
		if ( is_a( $input, WP_Post::class ) )
		{
			global $posts;
			$url = $posts[ $input->ID ][ 'url' ];
			return $url;
		}
		return null;
	}

	function get_page_by_path( $slug )
	{
		global $posts;
		$number_of_posts = count( $posts );
		for ( $i = 0; $i <= $number_of_posts; $i++ )
		{
			$post = $posts[ $i ];
			if ( $post[ 'slug' ] === $slug )
			{
				return get_post( $i );
			}
		}
	}