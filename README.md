WP Post Link
=========================

A simpler way to get link HTML by passing a post slug, ID, or WP_Post object.

## Example

Get post by slug:

    use WaughJ\WPPostLink\WPPostLink;
    $link = new WPPostLink([ 'slug' => 'contact-us' ]);
    echo $link;

## Changelog

### 0.2.8
* Fix getting post by slug so that it works for children of other pages
    * Previous version using slug inadvertedly seeked page by path, not slug. Now using a slug seeks by slug specifically

### 0.2.7
* Update TestHashItem dependency

### 0.2.6
* Make compatible with WordPress plugin rules

### 0.2.5
* Make compatible with WordPress plugin rules

### 0.2.4
* Make compatible with WordPress

### 0.2.3
* Make compatible with WordPress plugin rules

### 0.2.2
* Make default post_type mo' inclusive
    * Make default post_type mo' inclusive so that it includes all types o' posts 'stead o' just pages.

### 0.2.1
* Incorporate bugfix from HTMLLink 

### 0.2.0
* Add PostType

### 0.1.0
* Create initial usable release
