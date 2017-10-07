<?php
/**
 * Minimize.
 *
 * This file adds the landing page template to the Minimize Theme.
 *
 * Template Name: Landing Page
 *
 * @package Minimize
 * @author  SeoThemes
 * @license GPL-2.0+
 * @link    https://seothemes.com/themes/minimize
 */

/**
 * Add landing page body class to the head.
 *
 * @param  array $classes Array of body classes.
 * @return array $classes Array of body classes.
 */
function minimize_add_body_class( $classes ) {

	$classes[] = 'landing-page';

	return $classes;

}
add_filter( 'body_class', 'minimize_add_body_class' );

// Remove Skip Links.
remove_action( 'genesis_before_header', 'genesis_skip_links', 5 );

/**
 * Dequeue Skip Links Script.
 */
function minimize_dequeue_skip_links() {
	wp_dequeue_script( 'skip-links' );
}
add_action( 'wp_enqueue_scripts', 'minimize_dequeue_skip_links' );

// Force full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove site header elements.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Remove navigation.
remove_theme_support( 'genesis-menus' );

// Remove breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove footer widgets.
remove_theme_support( 'genesis-footer-widgets' );

// Remove site footer elements.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'minimize_footer_menu', 7 );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Run the Genesis loop.
genesis();
