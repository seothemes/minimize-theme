<?php
/**
 * This file adds helper functions used in the Minimize Theme.
 *
 * @package      Minimize
 * @link         https://seothemes.com/themes/minimize
 * @author       SEO Themes
 * @copyright    Copyright © 2017 SEO Themes
 * @license      GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {

	die;

}

add_action( 'genesis_entry_header', 'minimize_page_excerpt' );
/**
 * Display excerpt after entry header.
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
 * @param  array $page_templates All page templates.
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
 * @param string $hook The metabox hook.
 */
function minimize_remove_metaboxes( $hook ) {

	remove_meta_box( 'genesis-theme-settings-blogpage', $hook, 'main' );

}

/**
 * Sanitize RGBA values.
 *
 * If string does not start with 'rgba', then treat as hex then
 * sanitize the hex color and finally convert hex to rgba.
 *
 * @param  string $color The rgba color to sanitize.
 * @return string $color Sanitized value.
 */
function sanitize_rgba_color( $color ) {

	// Return invisible if empty.
	if ( empty( $color ) || is_array( $color ) ) {

		return 'rgba(0,0,0,0)';

	}

	// Return sanitized hex if not rgba value.
	if ( false === strpos( $color, 'rgba' ) ) {

		return sanitize_hex_color( $color );

	}

	// Finally, sanitize and return rgba.
	$color = str_replace( ' ', '', $color );
	sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );

	return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';

}

/**
 * Minify CSS helper function.
 *
 * @author Gary Jones
 * @link   https://github.com/GaryJones/Simple-PHP-CSS-Minification
 * @param  string $css The CSS to minify.
 * @return string Minified CSS.
 */
function minimize_minify_css( $css ) {

	// Normalize whitespace.
	$css = preg_replace( '/\s+/', ' ', $css );

	// Remove spaces before and after comment.
	$css = preg_replace( '/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $css );

	// Remove comment blocks, everything between /* and */, unless preserved with /*! ... */ or /** ... */.
	$css = preg_replace( '~/\*(?![\!|\*])(.*?)\*/~', '', $css );

	// Remove ; before }.
	$css = preg_replace( '/;(?=\s*})/', '', $css );

	// Remove space after , : ; { } */ >.
	$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

	// Remove space before , ; { } ( ) >.
	$css = preg_replace( '/ (,|;|\{|}|\(|\)|>)/', '$1', $css );

	// Strips leading 0 on decimal values (converts 0.5px into .5px).
	$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

	// Strips units if value is 0 (converts 0px to 0).
	$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

	// Converts all zeros value into short-hand.
	$css = preg_replace( '/0 0 0 0/', '0', $css );

	// Shorten 6-character hex color codes to 3-character where possible.
	$css = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css );

	return trim( $css );

}

/**
 * Helper function to check if we're on a WooCommerce page.
 *
 * @link   https://docs.woocommerce.com/document/conditional-tags/.
 * @return bool
 */
function minimize_is_woocommerce_page() {

	if ( ! class_exists( 'WooCommerce' ) ) {

		return false;

	}

	if ( is_woocommerce() || is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page() ) {

		return true;

	} else {

		return false;

	}

}

add_filter( 'display_posts_shortcode_post_class', 'minimize_dps_column_classes', 10, 4 );
/**
 * Column Classes
 *
 * Columns Extension for Display Posts Shortcode plugin makes it
 * easy for users to display posts in columns using
 * [display-posts columns="2"]
 *
 * @author Bill Erickson <bill@billerickson.net>
 * @link   http://www.billerickson.net/shortcode-to-display-posts/
 * @param  array  $classes Current CSS classes.
 * @param  object $post    The post object.
 * @param  object $listing The WP Query object for the listing.
 * @param  array  $atts    Original shortcode attributes.
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

	$column_classes = array( '', '', 'one-half', 'one-third', 'one-fourth', 'one-fifth', 'one-sixth' );
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
 * @param  string $creds Footer credits.
 * @return string
 */
function minimize_footer_creds_filter( $creds ) {

	$creds = 'Crafted with  <big class="ion-ios-bolt"></big>  by SEO Themes.';

	return $creds;

}

add_filter( 'wp_nav_menu_items', 'sws_social_icons', 10, 2 );
add_filter( 'genesis_nav_items', 'sws_social_icons', 10, 2 );
/**
 * Add widget area to nav-primary.
 *
 * @param  array $menu Menu content.
 * @param  array $args Menu args.
 *
 * @return string
 */
function sws_social_icons( $menu, $args ) {

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
 * @since  2.1.1
 * @return array Featured image size.
 */
function minimize_featured_image() {

	if ( ! is_singular( array( 'post', 'page', 'portfolio' ) ) ) {

		return;

	}

	if ( ! has_post_thumbnail() ) {

		return;

	}

	$genesis_settings = get_option( 'genesis-settings' );

	if ( 1 !== $genesis_settings['content_archive_thumbnail'] ) {

		return;

	}

	echo '<div class="featured-image">' . genesis_get_image() . '</div>';

}
