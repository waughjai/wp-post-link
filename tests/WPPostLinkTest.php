<?php

require_once( 'MockWordPress.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPPostLink\WPPostLink;

class WPPostLinkTest extends TestCase
{
	public function testMockPosts() : void
	{
		global $posts;
		$id = rand( 0, count( $posts ) - 1 );
		$selected_post = get_post( $id );
		$this->assertEquals( get_class( $selected_post ), WP_Post::class );
		$post_link = new WPPostLink( [ 'post' => $selected_post ] );
		$this->assertEquals( $post_link->getURL(), $posts[ $id ][ 'url' ] );
		$this->assertEquals( $post_link->getValue(), $posts[ $id ][ 'title' ] );
		$this->assertEquals( $post_link->getHTML(), '<a href="' . $posts[ $id ][ 'url' ] . '">' . $posts[ $id ][ 'title' ] . '</a>' );
	}

	public function testPostLinkBySlug() : void
	{
		$post_link = new WPPostLink([ 'slug' => 'google' ]);
		$this->assertEquals( $post_link->getURL(), 'https://www.google.com' );
		$this->assertEquals( $post_link->getValue(), 'Google' );
		$this->assertEquals( $post_link->getHTML(), '<a href="https://www.google.com">Google</a>' );
	}

	public function testPostLinkBySlugWithType() : void
	{
		$post_link = new WPPostLink([ 'slug' => 'google', 'post_type' => 'not_google' ]);
		$this->assertEquals( $post_link->getURL(), 'google' );
		$this->assertEquals( $post_link->getValue(), 'google' );
		$this->assertThat( $post_link->getHTML(), $this->logicalNot( $this->stringContains( 'https://www.google.com' ) ) );
	}

	public function testPostLinkByID() : void
	{
		$post_link = new WPPostLink([ 'post_id' => 1 ]);
		$this->assertEquals( $post_link->getURL(), 'https://www.google.com' );
		$this->assertEquals( $post_link->getValue(), 'Google' );
		$this->assertEquals( $post_link->getHTML(), '<a href="https://www.google.com">Google</a>' );
	}

	public function testPostLinkByTitle() : void
	{
		$post_link = new WPPostLink([ 'post_title' => 'Google' ]);
		$this->assertEquals( $post_link->getURL(), 'https://www.google.com' );
		$this->assertEquals( $post_link->getValue(), 'Google' );
		$this->assertEquals( $post_link->getHTML(), '<a href="https://www.google.com">Google</a>' );
	}

	public function testPostLinkWithAnchor() : void
	{
		$post_link = new WPPostLink([ 'post_title' => 'Google', 'anchor' => 'top' ]);
		$this->assertEquals( $post_link->getURL(), 'https://www.google.com#top' );
		$this->assertEquals( $post_link->getValue(), 'Google' );
		$this->assertEquals( $post_link->getHTML(), '<a href="https://www.google.com#top">Google</a>' );
	}
}
