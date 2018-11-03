<?php
/**
 * Minimize Theme
 *
 * This file loads the scripts and styles for the child theme.
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

add_action( 'wp_enqueue_scripts', 'minimize_scripts_styles', 999 );
/**
 * Enqueue theme scripts and styles.
 *
 * Add any custom scripts or styles by enqueueing them inside this function.
 *
 * @return void
 */
function minimize_scripts_styles() {

	// Google fonts.
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Playfair+Display|Open+Sans:300,400', array(), CHILD_THEME_VERSION );

	// Icon fonts.
	wp_enqueue_style( 'ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), CHILD_THEME_VERSION );

	// Enqueue responsive menu script.
	wp_enqueue_script( 'minimize', get_stylesheet_directory_uri() . '/assets/scripts/theme.js', array( 'minimize-menus' ), CHILD_THEME_VERSION, true );

	// Enqueue responsive menu script.
	wp_enqueue_script( 'minimize-menus', get_stylesheet_directory_uri() . '/assets/scripts/menus.js', array( 'jquery' ), CHILD_THEME_VERSION, true );

	// Localize responsive menus script.
	wp_localize_script( 'minimize-menus', 'genesis_responsive_menu',	array(
		'mainMenu'         => __( 'Menu', 'minimize' ),
		'subMenu'          => __( 'Menu', 'minimize' ),
		'menuIconClass'    => null,
		'subMenuIconClass' => null,
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
			),
		),
	) );

	// Conditionally load WooCommerce styles.
	if ( minimize_is_woocommerce_page() ) {

		wp_enqueue_style( 'starter-woocommerce', get_stylesheet_directory_uri() . '/assets/styles/min/woocommerce.min.css', array(), CHILD_THEME_VERSION );

	}

}
