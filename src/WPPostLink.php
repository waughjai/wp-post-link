<?php

declare( strict_types = 1 );
namespace WaughJ\WPPostLink
{
	use WaughJ\HTMLLink\HTMLLink;
	use function WaughJ\TestHashItem\TestHashItemExists;
	use function WaughJ\TestHashItem\TestHashItemString;

	class WPPostLink extends HTMLLink
	{
		public function __construct( array $atts )
		{
			$post = ( isset( $atts[ 'post' ] ) && is_a( $atts[ 'post' ], '\WP_Post' ) ) ? $atts[ 'post' ] : self::getPage( $atts );
			if ( $post !== null )
			{
				$url = get_permalink( $post );
				$value = TestHashItemExists( $atts, 'value', $post->post_title );
			}
			else
			{
				$url = TestHashItemString( $atts, 'slug', '' );
				$value = TestHashItemExists( $atts, 'value', $url );
			}
			parent::__construct( $url, $value, $atts );
		}

		private static function getPage( array $atts )
		{
			$post_type = TestHashItemString( $atts, 'post_type', get_post_types() );
			if ( TestHashItemString( $atts, 'slug' ) )
			{
				return get_page_by_path( $atts[ 'slug' ], OBJECT, $post_type );
			}
			else if ( isset( $atts[ 'post_id' ] ) )
			{
				return get_post( intval( $atts[ 'post_id' ] ) );
			}
			else if ( TestHashItemString( $atts, 'post_title' ) )
			{
				return get_page_by_title( $atts[ 'post_title' ], OBJECT, $post_type );
			}
			else
			{
				return null;
			}
		}
	}
}
