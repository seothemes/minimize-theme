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
 * @license GPL-3.0-or-later
 * @link    https://seothemes.com/themes/minimize
 */

add_filter( 'body_class', 'minimize_add_body_class' );
/**
 * Add landing page body class to the head.
 *
 * @since 1.0.0
 *
 * @param  array $classes Array of body classes.
 *
 * @return array $classes Array of body classes.
 */
function minimize_add_body_class( $classes ) {
	$classes[] = 'landing-page';

	return $classes;
}

add_action( 'wp_enqueue_scripts', 'minimize_dequeue_skip_links' );
/**
 * Dequeue Skip Links Script.
 *
 * @since 1.0.0
 *
 * @return void
 */
function minimize_dequeue_skip_links() {
	wp_dequeue_script( 'skip-links' );
}

// Remove Skip Links.
remove_action( 'genesis_before_header', 'genesis_skip_links', 5 );

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
