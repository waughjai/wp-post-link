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
			$url = get_permalink( $post );
			$text = TestHashItemExists( $atts, 'text', $post->post_title );
			parent::__construct( $url, $text, $atts );
		}

		private static function getPage( array $atts )
		{
			$post_type = TestHashItemString( $atts, 'post-type', 'page' );
			if ( TestHashItemString( $atts, 'slug' ) )
			{
				return get_page_by_path( $atts[ 'slug' ], OBJECT, $post_type );
			}
			else if ( TestHashItemString( $atts, 'id' ) )
			{
				return get_post( $atts[ 'id' ] );
			}
			else if ( TestHashItemString( $atts, 'title' ) )
			{
				return get_page_by_title( $atts[ 'title' ], OBJECT, $post_type );
			}
			else
			{
				return null;
			}
		}
	}
}
