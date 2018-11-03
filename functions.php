<?php
/**
 * Minimize Theme
 *
 * @package      SeoThemes\Minimize
 * @link         https://seothemes.com/themes/minimize
 * @author       SEO Themes
 * @copyright    Copyright © 2018 SEO Themes
 * @license      GPL-3.0-or-later
 */

// Define theme constants (do not remove).
$child_theme = wp_get_theme();
define( 'CHILD_THEME_NAME', $child_theme->get( 'Name' ) );
define( 'CHILD_THEME_URL', $child_theme->get( 'ThemeURI' ) );
define( 'CHILD_THEME_VERSION', $child_theme->get( 'Version' ) );
define( 'CHILD_TEXT_DOMAIN', $child_theme->get( 'TextDomain' ) );
define( 'CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );

// Child theme (do not remove).
include_once( get_template_directory() . '/lib/init.php' );

// Load theme includes.
include_once CHILD_THEME_DIR . '/includes/setup.php';
include_once CHILD_THEME_DIR . '/includes/helpers.php';
include_once CHILD_THEME_DIR . '/includes/general.php';
include_once CHILD_THEME_DIR . '/includes/enqueue.php';
include_once CHILD_THEME_DIR . '/includes/customize.php';
include_once CHILD_THEME_DIR . '/includes/defaults.php';
include_once CHILD_THEME_DIR . '/includes/plugins.php';
