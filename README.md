# WordPress APC Object Cache Backend #

Contributors: l3rady<br/>
Donate link: [http://l3rady.com/donate][2]<br/>
Tags: APC, object cache, backend, cache, performance, speed<br/>
Requires at least: 3.3<br/>
Tested up to: 4.2.4<br/>
Stable tag: 1.1.3

WordPress APC Object Cache Backend provides a persistent memory-based backend for the WordPress object cache.

## Description ##

WordPress APC Object Cache Backend provides a persistent memory-based backend for the WordPress object cache.

An object cache is a place for WordPress and WordPress extensions to store the results of complex operations. On subsequent loads,
this data can be fetched from the cache, which will be must faster than dynamically generating it on every page load.

Be sure to read the installation instructions, as this is **not** a traditional plugin, and needs to be installed in a specific location.

This object cache is a fork of [Mark Jaquith's APC Object Cache Backend][1]. There are a number of bugs in that version that have been
ignored so I decided to write my own version. The object cache has been pretty much been re-written but some of the best bits from Marks
version has been cherry picked over to this version.

## Installation ##

1. Verify that you have PHP 5.2.4+ and a compatible APC version installed.
2. Copy `object-cache.php` to your WordPress content directory (`wp-content/` by default).
3. Done!

## Frequently Asked Questions ##

### Does this support versions of WordPress earlier than 3.3? ###

Maybe, but I'm not going to support them, and you shouldn't still be running them!

### I share `wp-config.php` among multiple WordPress installs. How can I guarantee key uniqueness? ###

Define `WP_APC_KEY_SALT` to something that is unique for each install (like an md5 of the MySQL host, database, and table prefix).

## Changelog ##

### 1.1.3 ###
+ BUGFIX: Fix `wp_cache_flush_site()` to flush global groups [See][10]

### 1.1.2 ###
+ BUGFIX: Fix site cache key not saving in `_set_cache_version()` [See][9]

### 1.1.1 ###
+ BUGFIX: Fix logic in `get_cache_version()` [See][7]

### 1.1 ###
+ NEW: Add `wp_cache_flush_site()` and `wp_cache_flush_group()` [See][5]
+ NEW: Add `wp_cache_get_multi()` [See][4]
+ BUGFIX: If APC is not available then fallback to using non persistent cache [See][3]

### 1.0.2 ###
+ BUGFIX: Fix inverted logic in incr and decr functions [See][6]

### 1.0.1 ###
+ BUGFIX: On APC fetch convert arrayObject back to an array [See][7]

### 1.0 ###
+ Initial release

[1]: https://wordpress.org/plugins/apc/
[2]: http://l3rady.com/donate
[3]: https://github.com/l3rady/WordPress-APC-Object-Cache/pull/3
[4]: https://github.com/l3rady/WordPress-APC-Object-Cache/pull/4
[5]: https://github.com/l3rady/WordPress-APC-Object-Cache/pull/5
[6]: https://github.com/l3rady/WordPress-APC-Object-Cache/pull/2
[7]: https://github.com/l3rady/WordPress-APC-Object-Cache/pull/1
[8]: https://github.com/l3rady/WordPress-APC-Object-Cache/pull/7
[9]: https://github.com/l3rady/WordPress-APC-Object-Cache/pull/9
[10]: https://github.com/l3rady/WordPress-APC-Object-Cache/pull/10