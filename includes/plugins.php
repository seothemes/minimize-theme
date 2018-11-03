<?php
/**
 * Minimize Theme
 *
 * This file registers the required plugins for this theme.
 *
 * @package      SeoThemes\Minimize
 * @link         https://seothemes.com/themes/minimize
 * @author       SEO Themes
 * @copyright    Copyright © 2018 SEO Themes
 * @license      GPL-3.0-or-later
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once __DIR__ . '/tgmpa.php';

add_action( 'tgmpa_register', 'minimize_register_required_plugins' );
/**
 * Register required plugins.
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array
 * and remove the variable from the function call: `tgmpa( $plugins );`. In that case,
 * the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action
 * on priority 10.
 */
function minimize_register_required_plugins() {
	$plugins = array();

	$plugins[] = array(
		'name'     => 'Display Posts Shortcode',
		'slug'     => 'display-posts-shortcode',
		'required' => false,
	);
	$plugins[] = array(
		'name'     => 'Genesis Portfolio Pro',
		'slug'     => 'genesis-portfolio-pro',
		'required' => false,
	);
	$plugins[] = array(
		'name'     => 'Simple Social Icons',
		'slug'     => 'simple-social-icons',
		'required' => false,
	);
	$plugins[] = array(
		'name'     => 'Widget Importer & Exporter',
		'slug'     => 'widget-importer-exporter',
		'required' => false,
	);
	$plugins[] = array(
		'name'     => 'WordPress Importer',
		'slug'     => 'wordpress-importer',
		'required' => false,
	);
	$plugins[] = array(
		'name'     => 'WP Featherlight',
		'slug'     => 'wp-featherlight',
		'required' => false,
	);

	$config = array(
		'id'           => 'minimize',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}
