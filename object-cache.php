<?php
/*
Plugin Name: WordPress APC Object Cache Backend
Plugin URI: https://github.com/l3rady/WordPress-APC-Object-Cache
Description: APC backend for WordPress' Object Cache
Version: ???
Author: Scott Cariss
Author URI: http://l3rady.com
*/

// Stop direct access
!defined( 'ABSPATH' ) and exit;

// Set in config if you are using some sort of shared
// config where ABSPATH is the same on all sites
if ( !defined( 'WP_APC_KEY_SALT' ) ) {
	define( 'WP_APC_KEY_SALT', 'wp' );
}


/**
 * Adds data to the cache, if the cache key does not already exist.
 *
 * @param int|string $key    The cache key to use for retrieval later
 * @param mixed      $data   The data to add to the cache store
 * @param string     $group  The group to add the cache to
 * @param int        $expire When the cache data should be expired
 *
 * @return bool  False if cache key and group already exist, true on success
 */
function wp_cache_add( $key, $data, $group = '', $expire = 0 ) {
	global $wp_object_cache;

	return $wp_object_cache->add( $key, $data, $group, $expire );
}


/**
 * Closes the cache.
 *
 * This function has ceased to do anything since WordPress 2.5. The
 * functionality was removed along with the rest of the persistent cache. This
 * does not mean that plugins can't implement this function when they need to
 * make sure that the cache is cleaned up after WordPress no longer needs it.
 *
 * @return bool Always returns True
 */
function wp_cache_close() {
	return true;
}


/**
 * Decrement numeric cache item's value
 *
 * @param int|string $key    The cache key to increment
 * @param int        $offset The amount by which to decrement the item's value. Default is 1.
 * @param string     $group  The group the key is in.
 *
 * @return false|int False on failure, the item's new value on success.
 */
function wp_cache_decr( $key, $offset = 1, $group = '' ) {
	global $wp_object_cache;

	return $wp_object_cache->decr( $key, $offset, $group );
}


/**
 * Removes the cache contents matching key and group.
 *
 * @param int|string $key   What the contents in the cache are called
 * @param string     $group Where the cache contents are grouped
 *
 * @return bool True on successful removal, false on failure
 */
function wp_cache_delete( $key, $group = '' ) {
	global $wp_object_cache;

	return $wp_object_cache->delete( $key, $group );
}


/**
 * Removes all cache items.
 *
 * @return bool False on failure, true on success
 */
function wp_cache_flush() {
	global $wp_object_cache;

	return $wp_object_cache->flush();
}


/**
 * Retrieves the cache contents from the cache by key and group.
 *
 * @param int|string $key    What the contents in the cache are called
 * @param string     $group  Where the cache contents are grouped
 * @param bool       $force  Does nothing with APC object cache
 * @param bool       &$found Whether key was found in the cache. Disambiguates a return of false, a storable value.
 *
 * @return bool|mixed False on failure to retrieve contents or the cache contents on success
 */
function wp_cache_get( $key, $group = '', $force = false, &$found = null ) {
	global $wp_object_cache;

	return $wp_object_cache->get( $key, $group, $force, $found );
}


/**
 * Increment numeric cache item's value
 *
 * @param int|string $key    The cache key to increment
 * @param int        $offset The amount by which to increment the item's value. Default is 1.
 * @param string     $group  The group the key is in.
 *
 * @return false|int False on failure, the item's new value on success.
 */
function wp_cache_incr( $key, $offset = 1, $group = '' ) {
	global $wp_object_cache;

	return $wp_object_cache->incr( $key, $offset, $group );
}


/**
 * Sets up Object Cache Global and assigns it.
 *
 * @global WP_Object_Cache $wp_object_cache WordPress Object Cache
 */
function wp_cache_init() {
	$GLOBALS['wp_object_cache'] = new WP_Object_Cache();
}


/**
 * Replaces the contents of the cache with new data.
 *
 * @param int|string $key    What to call the contents in the cache
 * @param mixed      $data   The contents to store in the cache
 * @param string     $group  Where to group the cache contents
 * @param int        $expire When to expire the cache contents
 *
 * @return bool False if not exists, true if contents were replaced
 */
function wp_cache_replace( $key, $data, $group = '', $expire = 0 ) {
	global $wp_object_cache;

	return $wp_object_cache->replace( $key, $data, $group, $expire );
}


/**
 * Saves the data to the cache.
 *
 * @param int|string $key    What to call the contents in the cache
 * @param mixed      $data   The contents to store in the cache
 * @param string     $group  Where to group the cache contents
 * @param int        $expire When to expire the cache contents
 *
 * @return bool False on failure, true on success
 */
function wp_cache_set( $key, $data, $group = '', $expire = 0 ) {
	global $wp_object_cache;

	return $wp_object_cache->set( $key, $data, $group, $expire );
}


/**
 * Switch the internal blog id.
 *
 * This changes the blog id used to create keys in blog specific groups.
 *
 * @param int $blog_id Blog ID
 */
function wp_cache_switch_to_blog( $blog_id ) {
	global $wp_object_cache;

	$wp_object_cache->switch_to_blog( $blog_id );
}


/**
 * Adds a group or set of groups to the list of global groups.
 *
 * @param string|array $groups A group or an array of groups to add
 */
function wp_cache_add_global_groups( $groups ) {
	global $wp_object_cache;

	$wp_object_cache->add_global_groups( $groups );
}


/**
 * Adds a group or set of groups to the list of non-persistent groups.
 *
 * @param string|array $groups A group or an array of groups to add
 */
function wp_cache_add_non_persistent_groups( $groups ) {
	global $wp_object_cache;

	$wp_object_cache->add_non_persistent_groups( $groups );
}


/**
 * Function was depreciated and now does nothing
 *
 * @return bool Always returns false
 */
function wp_cache_reset() {
	global $wp_object_cache;

	return $wp_object_cache->reset();
}


class WP_Object_Cache {
	var $cache_hits = 0;
	var $cache_misses = 0;
	var $global_groups = array();
	var $non_persistent_groups = array();
	var $abspath = '';
	var $blog_prefix = '';


	function __construct() {
		global $blog_id;

		$this->abspath     = md5( ABSPATH );
		$this->multisite   = is_multisite();
		$this->blog_prefix = $this->multisite ? (int) $blog_id : 1;
	}


	function add_global_groups( $groups ) {
		$groups = (array) $groups;

		$groups = array_fill_keys( $groups, true );

		$this->global_groups = array_merge( $this->global_groups, $groups );
	}


	function add_non_persistent_groups( $groups ) {
		$groups = (array) $groups;

		$groups = array_fill_keys( $groups, true );

		$this->non_persistent_groups = array_merge( $this->non_persistent_groups, $groups );
	}


	function get( $key, $group = 'default', $force = false, &$success = null ) {
		unset( $force );

		$key = $this->_key( $key, $group );
		$var = apc_fetch( $key, $success );

		if ( $success ) {
			$this->cache_hits++;
			return $var;
		}

		$this->cache_misses++;
		return false;
	}


	function add( $key, $var, $group = 'default', $ttl = 0 ) {
		if ( wp_suspend_cache_addition() ) {
			return false;
		}

		return $this->_store_if_exists( $key, $var, $group, $ttl );
	}


	function set( $key, $var, $group = 'default', $ttl = 0 ) {
		return $this->_store( $key, $var, $group, $ttl );
	}


	function replace( $key, $var, $group = 'default', $ttl = 0 ) {
		return $this->_store_if_exists( $key, $var, $group, $ttl );
	}


	function delete( $key, $group = 'default', $deprecated = false ) {
		unset( $deprecated );

		$key = $this->_key( $key, $group );

		return apc_delete( $key );
	}


	function incr( $key, $offset = 1, $group = 'default' ) {
		return $this->_adjust( $key, $offset, $group );
	}


	function decr( $key, $offset = 1, $group = 'default' ) {
		$offset *= -1;

		return $this->_adjust( $key, $offset, $group );
	}


	function flush() {
		return apc_clear_cache( 'user' );
	}


	function reset() {
		_deprecated_function( __FUNCTION__, '3.5', 'switch_to_blog()' );
		return false;
	}


	function stats() {
		echo '<p>';
		echo '<strong>Cache Hits:</strong> ' . $this->cache_hits . '<br />';
		echo '<strong>Cache Misses:</strong> ' . $this->cache_misses . '<br />';
		echo '</p>';
	}


	function switch_to_blog( $blog_id ) {
		$blog_id           = (int) $blog_id;
		$this->blog_prefix = $this->multisite ? $blog_id : 1;
	}


	protected function _key( $key, $group ) {
		if ( empty( $group ) ) {
			$group = 'default';
		}

		$prefix = 0;

		if ( !isset( $this->global_groups[$group] ) ) {
			$prefix = $this->blog_prefix;
		}

		return WP_APC_KEY_SALT . ':' . $this->abspath . ':' . $prefix . ':' . $group . ':' . $key;
	}


	protected function _store( $key, $var, $group, $ttl ) {
		if ( !isset( $this->non_persistent_groups[$group] ) ) {
			return false;
		}

		$key = $this->_key( $key, $group );
		$ttl = max( intval( $ttl ), 0 );

		if ( is_object( $var ) ) {
			$var = clone $var;
		}

		if ( is_array( $var ) ) {
			$var = new ArrayObject( $var );
		}

		return apc_store( $key, $var, $ttl );
	}


	protected function _store_if_exists( $key, $var, $group, $ttl ) {
		$exist_key = $this->_key( $key, $group );

		if ( apc_exists( $exist_key ) ) {
			return false;
		}

		return $this->_store( $key, $var, $group, $ttl );
	}


	protected function _adjust( $key, $offset, $group ) {
		$offset = intval( $offset );
		$key    = $this->_key( $key, $group );
		$var    = intval( apc_fetch( $key ) );
		$var += $offset;

		return $var;
	}
}