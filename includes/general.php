<?php
/**
 * Minimize Theme
 *
 * This file loads the general functionality for the child theme.
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

add_action( 'genesis_entry_header', 'minimize_page_excerpt' );
/**
 * Display excerpt after entry header.
 *
 * @since 1.0.0
 *
 * @return void
 */
function minimize_page_excerpt() {
	if ( is_front_page() || is_single() && has_excerpt() ) {
		the_excerpt();
	}
}

add_filter( 'theme_page_templates', 'minimize_remove_templates' );
/**
 * Remove Page Templates.
 *
 * The Genesis Blog & Archive templates are not needed and can
 * create problems for users so it's safe to remove them. If
 * you need to use these templates, simply remove this function.
 *
 * @since 1.0.0
 *
 * @param  array $page_templates All page templates.
 *
 * @return array Modified templates.
 */
function minimize_remove_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );

	return $page_templates;
}

add_action( 'genesis_admin_before_metaboxes', 'minimize_remove_metaboxes' );
/**
 * Remove blog metabox.
 *
 * Also remove the Genesis blog settings metabox from the
 * Genesis admin settings screen as it is no longer required
 * if the Blog page template has been removed.
 *
 * @since 1.0.0
 *
 * @param string $hook The metabox hook.
 */
function minimize_remove_metaboxes( $hook ) {
	remove_meta_box( 'genesis-theme-settings-blogpage', $hook, 'main' );
}

add_filter( 'display_posts_shortcode_post_class', 'minimize_dps_column_classes', 10, 4 );
/**
 * Column Classes
 *
 * Columns Extension for Display Posts Shortcode plugin makes it
 * easy for users to display posts in columns using
 * [display-posts columns="2"]
 *
 * @since 1.0.0
 *
 * @author Bill Erickson <bill@billerickson.net>
 * @link   http://www.billerickson.net/shortcode-to-display-posts/
 *
 * @param  array $classes  Current CSS classes.
 * @param  object $post    The post object.
 * @param  object $listing The WP Query object for the listing.
 * @param  array $atts     Original shortcode attributes.
 *
 * @return array  $classes Modified CSS classes.
 */
function minimize_dps_column_classes( $classes, $post, $listing, $atts ) {
	if ( ! isset( $atts['columns'] ) ) {
		return $classes;
	}

	$columns = intval( $atts['columns'] );

	if ( $columns < 2 || $columns > 6 ) {
		return $classes;
	}

	$column_classes = array(
		'',
		'',
		'one-half',
		'one-third',
		'one-fourth',
		'one-fifth',
		'one-sixth'
	);

	$classes[] = $column_classes[ $columns ];

	if ( 0 == $listing->current_post % $columns ) {
		$classes[] = 'first';
	}

	return $classes;
}

add_filter( 'genesis_footer_creds_text', 'minimize_footer_creds_filter' );
/**
 * Change the footer text.
 *
 * @since 1.0.0
 *
 * @param  string $creds Footer credits.
 *
 * @return string
 */
function minimize_footer_creds_filter( $creds ) {
	$creds = 'Crafted with  <big class="ion-ios-bolt"></big>  by SEO Themes.';

	return $creds;
}

add_filter( 'wp_nav_menu_items', 'minimize_social_icons', 10, 2 );
add_filter( 'genesis_nav_items', 'minimize_social_icons', 10, 2 );
/**
 * Add widget area to nav-primary.
 *
 * @since 1.0.0
 *
 * @param  array $menu Menu content.
 * @param  array $args Menu args.
 *
 * @return string
 */
function minimize_social_icons( $menu, $args ) {
	$args = (array) $args;

	if ( 'primary' !== $args['theme_location'] ) {
		return $menu;
	}

	ob_start();
	genesis_widget_area( 'menu-widget', array(
		'before' => '<li class="menu-item menu-widget">',
		'after'  => '</li>',
	) );
	$social = ob_get_clean();

	return $menu . $social;
}

add_action( 'genesis_entry_content', 'minimize_featured_image', 0 );
/**
 * Display featured image before post content.
 *
 * Custom featured image function to do some checks before
 * outputting the featured image. It will return early if we're not
 * on a post, page or portfolio item or if the post doesn't have a
 * featured image set or if the featured image option set in
 * Genesis > Theme Settings is not checked.
 *
 * @since  1.0.0
 *
 * @return array Featured image size.
 */
function minimize_featured_image() {
	if ( ! is_singular( array(
			'post',
			'page',
			'portfolio'
		) ) || ! has_post_thumbnail() ) {
		return;
	}

	$genesis_settings = get_option( 'genesis-settings' );

	if ( 1 !== $genesis_settings['content_archive_thumbnail'] ) {
		return;
	}

	echo '<div class="featured-image">' . genesis_get_image() . '</div>';
}
