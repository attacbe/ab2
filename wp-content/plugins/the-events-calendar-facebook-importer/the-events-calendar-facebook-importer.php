<?php
/*
Plugin Name: The Events Calendar: Facebook Events
Description: Import events into The Events Calendar from a Facebook organization or page.
Version: 3.12
Author: Modern Tribe, Inc.
Author URI: http://m.tri.be/22
Text Domain: tribe-fb-import
License: GPLv2
*/

/*
Copyright 2012 Modern Tribe Inc. and the Collaborators

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * init the Facebook importer on plugins_loaded
 * ensures that TEC i s loaded first
 *
 * @since  1.0
 * @author jkudish
 * @return void
 */
add_action( 'plugins_loaded', 'tribe_init_facebook_importer', 99 );
function tribe_init_facebook_importer() {
	tribe_init_facebook_autoloading();

	$classes_exist = class_exists( 'Tribe__Events__Main' ) && class_exists( 'Tribe__Events__Facebook__Importer' );
	$version_ok = defined( 'Tribe__Events__Main::VERSION' ) && version_compare( Tribe__Events__Main::VERSION, Tribe__Events__Facebook__Importer::REQUIRED_TEC_VERSION, '>=' );

	if ( ! ( $classes_exist && $version_ok ) ) {
		require_once dirname( __FILE__ ) . '/src/Tribe/Importer.php';
		add_action( 'admin_notices', array( 'Tribe__Events__Facebook__Importer', 'fail_message' ) );

		return;
	}

	add_filter( 'tribe_tec_addons', array( 'Tribe__Events__Facebook__Importer', 'init_addon' ) );
	Tribe__Events__Facebook__Importer::instance();
	Tribe__Events__Facebook__Importer::$plugin_root = trailingslashit( dirname( __FILE__ ) );

	new Tribe__Events__Facebook__PUE( __FILE__ );
}

/**
 * clear WP Cron on plugin deactivation
 *
 * @see register_deactivation_hook()
 *
 * @param bool $network_deactivating
 */
function tribe_facebook_clear_schedule( $network_deactivating = false ) {
	if ( $network_deactivating && is_multisite() && ! wp_is_large_network() ) {
		/** @var wpdb $wpdb */
		global $wpdb;
		$site = get_current_site();
		$blog_ids = $wpdb->get_col( $wpdb->prepare( "SELECT blog_id FROM {$wpdb->blogs} WHERE site_id=%d", $site->id ) );
		foreach ( $blog_ids as $blog ) {
			set_time_limit( 30 );
			switch_to_blog( $blog );
			wp_clear_scheduled_hook( 'tribe_fb_auto_import' );
			restore_current_blog();
		}
	} else {
		wp_clear_scheduled_hook( 'tribe_fb_auto_import' );
	}
}

register_deactivation_hook( __FILE__, 'tribe_facebook_clear_schedule' );

/**
 * Requires the autoloader class from the main plugin class and sets up
 * autoloading.
 */
function tribe_init_facebook_autoloading() {
	if ( ! class_exists( 'Tribe__Events__Autoloader' ) ) {
		return;
	}

	$autoloader = Tribe__Events__Autoloader::instance();

	$autoloader->register_prefix( 'Tribe__Events__Facebook__', dirname( __FILE__ ) . '/src/Tribe' );

	// deprecated classes are registered in a class to path fashion
	foreach ( glob( dirname( __FILE__ ) . '/src/deprecated/*.php' ) as $file ) {
		$class_name = str_replace( '.php', '', basename( $file ) );
		$autoloader->register_class( $class_name, $file );
	}
	$autoloader->register_autoloader();
}
