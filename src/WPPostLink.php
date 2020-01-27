<?php

declare( strict_types = 1 );
namespace WaughJ\WPPostLink;

use WaughJ\HTMLLink\HTMLLink;
use WaughJ\TestHashItem\TestHashItem;

class WPPostLink extends HTMLLink
{
	public function __construct( array $atts )
	{
		$post = ( isset( $atts[ 'post' ] ) && is_a( $atts[ 'post' ], '\WP_Post' ) ) ? $atts[ 'post' ] : self::getPage( $atts );
		if ( $post !== null )
		{
			$url = get_permalink( $post );
			$value = $atts[ 'value' ] ?? $post->post_title;
		}
		else
		{
			$url = TestHashItem::getString( $atts, 'slug', '' );
			$value = $atts[ 'value' ] ?? $url;
		}
		parent::__construct( $url, $value, $atts );
	}

	private static function getPage( array $atts )
	{
		$post_type = TestHashItem::getString( $atts, 'post_type', get_post_types() );
		if ( isset( $atts[ 'post_id' ] ) )
		{
			return get_post( intval( $atts[ 'post_id' ] ) );
		}
		else if ( TestHashItem::getString( $atts, 'post_title' ) )
		{
			return get_page_by_title( $atts[ 'post_title' ], OBJECT, $post_type );
		}
		else
		{
			if ( TestHashItem::getString( $atts, 'slug' ) )
			{
				$atts[ 'name' ] = $atts[ 'slug' ];
				unset( $atts[ 'slug' ] );
			}
			$posts = get_posts( $atts );
			if ( empty( $posts ) )
			{
				return null;
			}
			return $posts[ 0 ];
		}
	}
}
