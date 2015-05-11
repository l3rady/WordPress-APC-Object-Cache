<?php
/*
Plugin Name: WordPress APC Object Cache Backend
Plugin URI: https://github.com/l3rady/WordPress-APC-Object-Cache
Description: APC backend for WordPress' Object Cache
Version: 1.1.2
Author: Scott Cariss
Author URI: http://l3rady.com
*/

/*  Copyright 2015  Scott Cariss  (email : scott@l3rady.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Stop direct access
!defined( 'ABSPATH' ) and exit;


/**
 * Adds data to the cache, if the cache key does not already exist.
 *
 * @param int|string $key    The cache key to use for retrieval later
 * @param mixed      $data   The data to add to the cache store
 * @param string     $group  The group to add the cache to
 * @param int        $expire When the cache data should be expired
 *
 * @return bool False if cache key and group already exist, true on success
 */
function wp_cache_add( $key, $data, $group = 'default', $expire = 0 ) {
	return WP_Object_Cache::instance()->add( $key, $data, $group, $expire );
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
function wp_cache_decr( $key, $offset = 1, $group = 'default' ) {
	return WP_Object_Cache::instance()->decr( $key, $offset, $group );
}


/**
 * Removes the cache contents matching key and group.
 *
 * @param int|string $key   What the contents in the cache are called
 * @param string     $group Where the cache contents are grouped
 *
 * @return bool True on successful removal, false on failure
 */
function wp_cache_delete( $key, $group = 'default' ) {
	return WP_Object_Cache::instance()->delete( $key, $group );
}


/**
 * Removes all cache items.
 *
 * @return bool False on failure, true on success
 */
function wp_cache_flush() {
	return WP_Object_Cache::instance()->flush();
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
function wp_cache_get( $key, $group = 'default', $force = false, &$found = null ) {
	return WP_Object_Cache::instance()->get( $key, $group, $force, $found );
}


/**
 * Retrieve multiple values from cache.
 *
 * Gets multiple values from cache, including across multiple groups
 *
 * Usage: array( 'group0' => array( 'key0', 'key1', 'key2', ), 'group1' => array( 'key0' ) )
 *
 * @param array $groups Array of groups and keys to retrieve
 *
 * @return array Array of cached values as
 *    array( 'group0' => array( 'key0' => 'value0', 'key1' => 'value1', 'key2' => 'value2', ) )
 *    Non-existent keys are not returned.
 */
function wp_cache_get_multi( $groups ) {
	return WP_Object_Cache::instance()->get_multi( $groups );
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
function wp_cache_incr( $key, $offset = 1, $group = 'default' ) {
	return WP_Object_Cache::instance()->incr( $key, $offset, $group );
}


/**
 * Sets up Object Cache Global and assigns it.
 *
 * @global WP_Object_Cache $wp_object_cache WordPress Object Cache
 */
function wp_cache_init() {
	$GLOBALS['wp_object_cache'] = WP_Object_Cache::instance();
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
function wp_cache_replace( $key, $data, $group = 'default', $expire = 0 ) {
	return WP_Object_Cache::instance()->replace( $key, $data, $group, $expire );
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
function wp_cache_set( $key, $data, $group = 'default', $expire = 0 ) {
	return WP_Object_Cache::instance()->set( $key, $data, $group, $expire );
}


/**
 * Switch the internal blog id.
 *
 * This changes the blog id used to create keys in blog specific groups.
 *
 * @param int $blog_id Blog ID
 */
function wp_cache_switch_to_blog( $blog_id ) {
	WP_Object_Cache::instance()->switch_to_blog( $blog_id );
}


/**
 * Adds a group or set of groups to the list of global groups.
 *
 * @param string|array $groups A group or an array of groups to add
 */
function wp_cache_add_global_groups( $groups ) {
	WP_Object_Cache::instance()->add_global_groups( $groups );
}


/**
 * Adds a group or set of groups to the list of non-persistent groups.
 *
 * @param string|array $groups A group or an array of groups to add
 */
function wp_cache_add_non_persistent_groups( $groups ) {
	WP_Object_Cache::instance()->add_non_persistent_groups( $groups );
}


/**
 * Function was depreciated and now does nothing
 *
 * @return bool Always returns false
 */
function wp_cache_reset() {
	_deprecated_function( __FUNCTION__, '3.5', 'wp_cache_switch_to_blog()' );
	return false;
}


/**
 * Invalidate a site's object cache
 *
 * @param mixed $sites Sites ID's that want flushing.
 *                     Don't pass a site to flush current site
 *
 * @return bool
 */
function wp_cache_flush_site( $sites = null ) {
	return WP_Object_Cache::instance()->flush_sites( $sites );
}


/**
 * Invalidate a groups object cache
 *
 * @param mixed $groups A group or an array of groups to invalidate
 *
 * @return bool
 */
function wp_cache_flush_group( $groups = 'default' ) {
	return WP_Object_Cache::instance()->flush_groups( $groups );
}


/**
 * WordPress APC Object Cache Backend
 *
 * The WordPress Object Cache is used to save on trips to the database. The
 * APC Object Cache stores all of the cache data to APC and makes the cache
 * contents available by using a key, which is used to name and later retrieve
 * the cache contents.
 */
class WP_Object_Cache {
	/**
	 * @var string MD5 hash of the current installation ABSPATH
	 */
	private $abspath = '';


	/**
	 * @var bool Stores if APC is available.
	 */
	private $apc_available = false;


	/**
	 * @var int The sites current blog ID. This only
	 *    differs if running a multi-site installations
	 */
	private $blog_prefix = 1;


	/**
	 * @var int Keeps count of how many times the
	 *    cache was successfully received from APC
	 */
	private $cache_hits = 0;


	/**
	 * @var int Keeps count of how many times the
	 *    cache was not successfully received from APC
	 */
	private $cache_misses = 0;


	/**
	 * @var array Holds a list of cache groups that are
	 *    shared across all sites in a multi-site installation
	 */
	private $global_groups = array();


	/**
	 * @var array Holds an array of versions of the retrieved groups
	 */
	private $group_versions = array();


	/**
	 * @var bool True if the current installation is a multi-site
	 */
	private $multi_site = false;


	/**
	 * @var array Holds cache that is to be non persistent
	 */
	private $non_persistent_cache = array();


	/**
	 * @var array Holds a list of cache groups that are not to be saved to APC
	 */
	private $non_persistent_groups = array();


	/**
	 * @var array Holds an array of versions of the retrieved sites
	 */
	private $site_versions = array();


	/**
	 * Singleton. Return instance of WP_Object_Cache
	 *
	 * @return WP_Object_Cache
	 */
	public static function instance() {
		static $inst = null;

		if ( $inst === null ) {
			$inst = new WP_Object_Cache();
		}

		return $inst;
	}


	/**
	 * __clone not allowed
	 */
	private function __clone() {
	}


	/**
	 * Direct access to __construct not allowed.
	 */
	private function __construct() {
		global $blog_id;

		if ( !defined( 'WP_APC_KEY_SALT' ) ) {
			/**
			 * Set in config if you are using some sort of shared
			 * config where ABSPATH is the same on all sites
			 */
			define( 'WP_APC_KEY_SALT', 'wp' );
		}

		$this->abspath       = md5( ABSPATH );
		$this->apc_available = ( extension_loaded( 'apc' ) && ini_get( 'apc.enabled' ) );
		$this->multi_site    = is_multisite();
		$this->blog_prefix   = $this->multi_site ? (int) $blog_id : 1;
	}


	/**
	 * Adds data to the cache, if the cache key does not already exist.
	 *
	 * @param int|string $key   The cache key to use for retrieval later
	 * @param mixed      $var   The data to add to the cache store
	 * @param string     $group The group to add the cache to
	 * @param int        $ttl   When the cache data should be expired
	 *
	 * @return bool False if cache key and group already exist, true on success
	 */
	public function add( $key, $var, $group = 'default', $ttl = 0 ) {
		if ( wp_suspend_cache_addition() ) {
			return false;
		}

		$key = $this->_key( $key, $group );

		if ( !$this->apc_available || $this->_is_non_persistent_group( $group ) ) {
			return $this->_add_np( $key, $var );
		}

		return $this->_add( $key, $var, $ttl );
	}


	/**
	 * Adds data to APC cache, if the cache key does not already exist.
	 *
	 * @param string $key The cache key to use for retrieval later
	 * @param mixed  $var The data to add to the cache store
	 * @param int    $ttl When the cache data should be expired
	 *
	 * @return bool False if cache key and group already exist, true on success
	 */
	private function _add( $key, $var, $ttl ) {
		if ( $this->_exists( $key ) ) {
			return false;
		}

		return $this->_set( $key, $var, $ttl );
	}


	/**
	 * Adds data to non persistent cache, if the cache key does not already exist.
	 *
	 * @param string $key The cache key to use for retrieval later
	 * @param mixed  $var The data to add to the cache store
	 *
	 * @return bool False if cache key and group already exist, true on success
	 */
	private function _add_np( $key, $var ) {
		if ( $this->_exists_np( $key ) ) {
			return false;
		}

		return $this->_set_np( $key, $var );
	}


	/**
	 * Sets the list of global groups.
	 *
	 * @param string|array $groups List of groups that are global.
	 */
	public function add_global_groups( $groups ) {
		$groups = (array) $groups;

		$groups = array_fill_keys( $groups, true );

		$this->global_groups = array_merge( $this->global_groups, $groups );
	}


	/**
	 * Sets the list of non persistent groups.
	 *
	 * @param string|array $groups List of groups that are non persistent.
	 */
	public function add_non_persistent_groups( $groups ) {
		$groups = (array) $groups;

		$groups = array_fill_keys( $groups, true );

		$this->non_persistent_groups = array_merge(
			$this->non_persistent_groups,
			$groups
		);
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
	public function decr( $key, $offset = 1, $group = 'default' ) {
		$key = $this->_key( $key, $group );

		if ( !$this->apc_available || $this->_is_non_persistent_group( $group ) ) {
			return $this->_decr_np( $key, $offset );
		}

		return $this->_decr( $key, $offset );
	}


	/**
	 * Decrement numeric APC cache item's value
	 *
	 * @param string $key    The cache key to increment
	 * @param int    $offset The amount by which to decrement the item's value. Default is 1.
	 *
	 * @return false|int False on failure, the item's new value on success.
	 */
	private function _decr( $key, $offset ) {
		if ( !$this->_exists( $key ) ) {
			return false;
		}

		$offset = max( intval( $offset ), 0 );

		return apc_dec( $key, $offset );
	}


	/**
	 * Decrement numeric non persistent cache item's value
	 *
	 * @param string $key    The cache key to increment
	 * @param int    $offset The amount by which to decrement the item's value. Default is 1.
	 *
	 * @return false|int False on failure, the item's new value on success.
	 */
	private function _decr_np( $key, $offset ) {
		if ( !$this->_exists_np( $key ) ) {
			return false;
		}

		$offset = max( intval( $offset ), 0 );
		$var    = $this->_get_np( $key );
		$var    = is_numeric( $var ) ? $var : 0;
		$var    = $var - $offset;

		return $this->_set_np( $key, $var );
	}


	/**
	 * Remove the contents of the cache key in the group
	 *
	 * If the cache key does not exist in the group, then nothing will happen.
	 *
	 * @param int|string $key        What the contents in the cache are called
	 * @param string     $group      Where the cache contents are grouped
	 * @param bool       $deprecated Deprecated.
	 *
	 * @return bool False if the contents weren't deleted and true on success
	 */
	public function delete( $key, $group = 'default', $deprecated = false ) {
		unset( $deprecated );

		$key = $this->_key( $key, $group );

		if ( !$this->apc_available || $this->_is_non_persistent_group( $group ) ) {
			return $this->_delete_np( $key );
		}

		return $this->_delete( $key );
	}


	/**
	 * Remove the contents of the APC cache key in the group
	 *
	 * If the cache key does not exist in the group, then nothing will happen.
	 *
	 * @param string $key What the contents in the cache are called
	 *
	 * @return bool False if the contents weren't deleted and true on success
	 */
	private function _delete( $key ) {
		return apc_delete( $key );
	}


	/**
	 * Remove the contents of the non persistent cache key in the group
	 *
	 * If the cache key does not exist in the group, then nothing will happen.
	 *
	 * @param string $key What the contents in the cache are called
	 *
	 * @return bool False if the contents weren't deleted and true on success
	 */
	private function _delete_np( $key ) {
		if ( isset( $this->non_persistent_cache[$key] ) ) {
			unset( $this->non_persistent_cache[$key] );

			return true;
		}

		return false;
	}


	/**
	 * Checks if the cached APC key exists
	 *
	 * @param string $key What the contents in the cache are called
	 *
	 * @return bool True if cache key exists else false
	 */
	private function _exists( $key ) {
		return apc_exists( $key );
	}


	/**
	 * Checks if the cached non persistent key exists
	 *
	 * @param string $key What the contents in the cache are called
	 *
	 * @return bool True if cache key exists else false
	 */
	private function _exists_np( $key ) {
		return isset( $this->non_persistent_cache[$key] );
	}


	/**
	 * Clears the object cache of all data
	 *
	 * @return bool Always returns true
	 */
	public function flush() {
		$this->non_persistent_cache = array();

		if ( $this->apc_available ) {
			apc_clear_cache( 'user' );
		}

		return true;
	}


	/**
	 * Invalidate a groups object cache
	 *
	 * @param mixed $groups A group or an array of groups to invalidate
	 *
	 * @return bool
	 */
	public function flush_groups( $groups ) {
		$groups = (array) $groups;

		if ( empty( $groups ) ) {
			return false;
		}

		foreach ( $groups as $group ) {
			$version = $this->_get_group_cache_version( $group );
			$version++;
			$this->_set_group_cache_version( $group, $version );
		}

		return true;
	}


	/**
	 * Invalidate a site's object cache
	 *
	 * @param mixed $sites Sites ID's that want flushing.
	 *                     Don't pass a site to flush current site
	 *
	 * @return bool
	 */
	public function flush_sites( $sites ) {
		$sites = (array) $sites;

		if ( empty( $sites ) ) {
			$sites = array( $this->blog_prefix );
		}

		foreach ( $sites as $site ) {
			$version = $this->_get_site_cache_version( $site );
			$version++;
			$this->_set_site_cache_version( $site, $version );
		}

		return true;
	}


	/**
	 * Retrieves the cache contents, if it exists
	 *
	 * The contents will be first attempted to be retrieved by searching by the
	 * key in the cache key. If the cache is hit (success) then the contents
	 * are returned.
	 *
	 * On failure, the number of cache misses will be incremented.
	 *
	 * @param int|string $key   What the contents in the cache are called
	 * @param string     $group Where the cache contents are grouped
	 * @param bool       $force Not used.
	 * @param bool       &$success
	 *
	 * @return bool|mixed False on failure to retrieve contents or the cache contents on success
	 */
	public function get( $key, $group = 'default', $force = false, &$success = null ) {
		unset( $force );

		$key = $this->_key( $key, $group );

		if ( !$this->apc_available || $this->_is_non_persistent_group( $group ) ) {
			$var = $this->_get_np( $key, $success );
		}
		else {
			$var = $this->_get( $key, $success );
		}

		if ( $success ) {
			$this->cache_hits++;
		}
		else {
			$this->cache_misses++;
		}

		return $var;
	}


	/**
	 * Retrieves the APC cache contents, if it exists
	 *
	 * @param string $key What the contents in the cache are called
	 * @param bool   &$success
	 *
	 * @return bool|mixed False on failure to retrieve contents or the cache contents on success
	 */
	private function _get( $key, &$success = null ) {
		$var = apc_fetch( $key, $success );

		if ( is_object( $var ) && 'ArrayObject' === get_class( $var ) ) {
			$var = $var->getArrayCopy();
		}
		elseif ( null === $var ) {
			$var = false;
		}
		elseif ( is_object( $var ) ) {
			$var = clone $var;
		}

		return $var;
	}


	/**
	 * Retrieves the non persistent cache contents, if it exists
	 *
	 * @param string $key What the contents in the cache are called
	 * @param bool   &$success
	 *
	 * @return bool|mixed False on failure to retrieve contents or the cache contents on success
	 */
	private function _get_np( $key, &$success = null ) {
		if ( isset( $this->non_persistent_cache[$key] ) ) {
			$success = true;
			return $this->non_persistent_cache[$key];
		}

		return $success = false;
	}


	/**
	 * Get the cache version of a given key
	 *
	 * @param string $key
	 *
	 * @return int cache version
	 */
	private function _get_cache_version( $key ) {
		if ( $this->apc_available ) {
			$version = (int) apc_fetch( $key );
		}
		elseif ( isset( $this->non_persistent_cache[$key] ) ) {
			$version = (int) $this->non_persistent_cache[$key];
		}
		else {
			$version = 0;
		}

		return $version;
	}


	/**
	 * Build cache version key
	 *
	 * @param string $type  Type of key, for site or group
	 * @param mixed  $value the group or site id
	 *
	 * @return string The key
	 */
	private function _get_cache_version_key( $type, $value ) {
		return WP_APC_KEY_SALT . ':' . $this->abspath . ':' . $type . ':' . $value;
	}


	/**
	 * Get the groups cache version
	 *
	 * @param string $group The group to get version for
	 *
	 * @return int The group cache version
	 */
	private function _get_group_cache_version( $group ) {
		if ( !isset( $this->group_versions[$group] ) ) {
			$this->group_versions[$group] = $this->_get_cache_version(
				$this->_get_cache_version_key(
					'GroupVersion',
					$group
				)
			);
		}

		return $this->group_versions[$group];
	}


	/**
	 * Retrieve multiple values from cache.
	 *
	 * Gets multiple values from cache, including across multiple groups
	 *
	 * Usage: array( 'group0' => array( 'key0', 'key1', 'key2', ), 'group1' => array( 'key0' ) )
	 *
	 * @param array $groups Array of groups and keys to retrieve
	 *
	 * @return array Array of cached values as
	 *    array( 'group0' => array( 'key0' => 'value0', 'key1' => 'value1', 'key2' => 'value2', ) )
	 *    Non-existent keys are not returned.
	 */
	public function get_multi( $groups ) {
		if ( empty( $groups ) || !is_array( $groups ) ) {
			return false;
		}

		$vars    = array();
		$success = false;

		foreach ( $groups as $group => $keys ) {
			$vars[$group] = array();

			foreach ( $keys as $key ) {
				$var = $this->get( $key, $group, false, $success );

				if ( $success ) {
					$vars[$group][$key] = $var;
				}
			}
		}

		return $vars;
	}


	/**
	 * Get the sites cache version
	 *
	 * @param int $site The site to get version for
	 *
	 * @return int The site cache version
	 */
	private function _get_site_cache_version( $site ) {
		if ( !isset( $this->site_versions[$site] ) ) {
			$this->site_versions[$site] = $this->_get_cache_version(
				$this->_get_cache_version_key(
					'SiteVersion',
					$site
				)
			);
		}

		return $this->site_versions[$site];
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
	public function incr( $key, $offset = 1, $group = 'default' ) {
		$key = $this->_key( $key, $group );

		if ( !$this->apc_available || $this->_is_non_persistent_group( $group ) ) {
			return $this->_incr_np( $key, $offset );
		}

		return $this->_incr( $key, $offset );
	}


	/**
	 * Increment numeric APC cache item's value
	 *
	 * @param string $key    The cache key to increment
	 * @param int    $offset The amount by which to increment the item's value. Default is 1.
	 *
	 * @return false|int False on failure, the item's new value on success.
	 */
	private function _incr( $key, $offset ) {
		if ( !$this->_exists( $key ) ) {
			return false;
		}

		$offset = max( intval( $offset ), 0 );

		return apc_inc( $key, $offset );
	}


	/**
	 * Increment numeric non persistent cache item's value
	 *
	 * @param string $key    The cache key to increment
	 * @param int    $offset The amount by which to increment the item's value. Default is 1.
	 *
	 * @return false|int False on failure, the item's new value on success.
	 */
	private function _incr_np( $key, $offset ) {
		if ( !$this->_exists_np( $key ) ) {
			return false;
		}

		$offset = max( intval( $offset ), 0 );
		$var    = $this->_get_np( $key );
		$var    = is_numeric( $var ) ? $var : 0;
		$var    = $var + $offset;

		return $this->_set_np( $key, $var );
	}


	/**
	 * Checks if the given group is a non persistent group
	 *
	 * @param string $group The group to be checked
	 *
	 * @return bool True if the group is a non persistent group else false
	 */
	private function _is_non_persistent_group( $group ) {
		return isset( $this->non_persistent_groups[$group] );
	}


	/**
	 * Works out a cache key based on a given key and group
	 *
	 * @param int|string $key   The key
	 * @param string     $group The group
	 *
	 * @return string Returns the calculated cache key
	 */
	private function _key( $key, $group ) {
		if ( empty( $group ) ) {
			$group = 'default';
		}

		$prefix = 0;

		if ( !isset( $this->global_groups[$group] ) ) {
			$prefix = $this->blog_prefix;
		}

		$group_version = $this->_get_group_cache_version( $group );
		$site_version  = $this->_get_site_cache_version( $prefix );

		return WP_APC_KEY_SALT . ':' . $this->abspath . ':' . $prefix . ':' . $group . ':' . $key . ':v' . $site_version . '.' . $group_version;
	}


	/**
	 * Replace the contents in the cache, if contents already exist
	 *
	 * @param int|string $key   What to call the contents in the cache
	 * @param mixed      $var   The contents to store in the cache
	 * @param string     $group Where to group the cache contents
	 * @param int        $ttl   When to expire the cache contents
	 *
	 * @return bool False if not exists, true if contents were replaced
	 */
	public function replace( $key, $var, $group = 'default', $ttl = 0 ) {
		$key = $this->_key( $key, $group );

		if ( !$this->apc_available || $this->_is_non_persistent_group( $group ) ) {
			return $this->_replace_np( $key, $var );
		}

		return $this->_replace( $key, $var, $ttl );
	}


	/**
	 * Replace the contents in the APC cache, if contents already exist
	 *
	 * @param string $key What to call the contents in the cache
	 * @param mixed  $var The contents to store in the cache
	 * @param int    $ttl When to expire the cache contents
	 *
	 * @return bool False if not exists, true if contents were replaced
	 */
	private function _replace( $key, $var, $ttl ) {
		if ( !$this->_exists( $key ) ) {
			return false;
		}

		return $this->_set( $key, $var, $ttl );
	}


	/**
	 * Replace the contents in the non persistent cache, if contents already exist
	 *
	 * @param string $key What to call the contents in the cache
	 * @param mixed  $var The contents to store in the cache
	 *
	 * @return bool False if not exists, true if contents were replaced
	 */
	private function _replace_np( $key, $var ) {
		if ( !$this->_exists_np( $key ) ) {
			return false;
		}

		return $this->_set_np( $key, $var );
	}


	/**
	 * Sets the data contents into the cache
	 *
	 * @param int|string $key   What to call the contents in the cache
	 * @param mixed      $var   The contents to store in the cache
	 * @param string     $group Where to group the cache contents
	 * @param int        $ttl   When the cache data should be expired
	 *
	 * @return bool True if cache set successfully else false
	 */
	public function set( $key, $var, $group = 'default', $ttl = 0 ) {
		$key = $this->_key( $key, $group );

		if ( !$this->apc_available || $this->_is_non_persistent_group( $group ) ) {
			return $this->_set_np( $key, $var );
		}

		return $this->_set( $key, $var, $ttl );
	}


	/**
	 * Sets the data contents into the APC cache
	 *
	 * @param string $key What to call the contents in the cache
	 * @param mixed  $var The contents to store in the cache
	 * @param int    $ttl When the cache data should be expired
	 *
	 * @return bool True if cache set successfully else false
	 */
	private function _set( $key, $var, $ttl ) {
		$ttl = max( intval( $ttl ), 0 );

		if ( is_object( $var ) ) {
			$var = clone $var;
		}

		if ( is_array( $var ) ) {
			$var = new ArrayObject( $var );
		}

		return apc_store( $key, $var, $ttl );
	}


	/**
	 * Sets the data contents into the non persistent cache
	 *
	 * @param string $key What to call the contents in the cache
	 * @param mixed  $var The contents to store in the cache
	 *
	 * @return bool True if cache set successfully else false
	 */
	private function _set_np( $key, $var ) {
		if ( is_object( $var ) ) {
			$var = clone $var;
		}

		return $this->non_persistent_cache[$key] = $var;
	}


	/**
	 * Set the cache version for a given key
	 *
	 * @param string $key
	 * @param int    $version
	 *
	 * @return mixed
	 */
	private function _set_cache_version( $key, $version ) {
		if ( $this->apc_available ) {
			return apc_store( $key, $version );
		}
		else {
			return $this->non_persistent_cache[$key] = $version;
		}
	}


	/**
	 * Set the version for a groups cache
	 *
	 * @param string $group
	 * @param int    $version
	 */
	private function _set_group_cache_version( $group, $version ) {
		$this->_set_cache_version( $this->_get_cache_version_key( 'GroupVersion', $group ), $version );
	}


	/**
	 * Set the version for a sites cache
	 *
	 * @param int $site
	 * @param int $version
	 */
	private function _set_site_cache_version( $site, $version ) {
		$this->_set_cache_version( $this->_get_cache_version_key( 'SiteVersion', $site ), $version );
	}


	/**
	 * Switch the internal blog id.
	 *
	 * This changes the blog id used to create keys in blog specific groups.
	 *
	 * @param int $blog_id Blog ID
	 */
	public function switch_to_blog( $blog_id ) {
		$blog_id           = (int) $blog_id;
		$this->blog_prefix = $this->multi_site ? $blog_id : 1;
	}


	/**
	 * @return string
	 */
	public function getAbspath() {
		return $this->abspath;
	}


	/**
	 * @return boolean
	 */
	public function getApcAvailable() {
		return $this->apc_available;
	}


	/**
	 * @return int
	 */
	public function getBlogPrefix() {
		return $this->blog_prefix;
	}


	/**
	 * @return int
	 */
	public function getCacheHits() {
		return $this->cache_hits;
	}


	/**
	 * @return int
	 */
	public function getCacheMisses() {
		return $this->cache_misses;
	}


	/**
	 * @return array
	 */
	public function getGlobalGroups() {
		return $this->global_groups;
	}


	/**
	 * @return array
	 */
	public function getGroupVersions() {
		return $this->group_versions;
	}


	/**
	 * @return boolean
	 */
	public function getMultiSite() {
		return $this->multi_site;
	}


	/**
	 * @return array
	 */
	public function getNonPersistentCache() {
		return $this->non_persistent_cache;
	}


	/**
	 * @return array
	 */
	public function getNonPersistentGroups() {
		return $this->non_persistent_groups;
	}


	/**
	 * @return array
	 */
	public function getSiteVersions() {
		return $this->site_versions;
	}
}
