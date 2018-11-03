<?php
/**
 * Minimize Theme
 *
 * This file adds helper functions used in the Minimize Theme.
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

/**
 * Sanitize RGBA values.
 *
 * If string does not start with 'rgba', then treat as hex then
 * sanitize the hex color and finally convert hex to rgba.
 *
 * @since 1.0.0
 *
 * @param  string $color The rgba color to sanitize.
 *
 * @return string $color Sanitized value.
 */
function minimize_sanitize_rgba_color( $color ) {
	if ( empty( $color ) || is_array( $color ) ) {
		return 'rgba(0,0,0,0)';
	}

	if ( false === strpos( $color, 'rgba' ) ) {
		return sanitize_hex_color( $color );
	}

	$color = str_replace( ' ', '', $color );
	sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );

	return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';
}

/**
 * Minify CSS helper function.
 *
 * @since  1.0.0
 *
 * @author Gary Jones
 * @link   https://github.com/GaryJones/Simple-PHP-CSS-Minification
 *
 * @param  string $css The CSS to minify.
 *
 * @return string Minified CSS.
 */
function minimize_minify_css( $css ) {
	$css = preg_replace( '/\s+/', ' ', $css );
	$css = preg_replace( '/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $css );
	$css = preg_replace( '~/\*(?![\!|\*])(.*?)\*/~', '', $css );
	$css = preg_replace( '/;(?=\s*})/', '', $css );
	$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );
	$css = preg_replace( '/ (,|;|\{|}|\(|\)|>)/', '$1', $css );
	$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );
	$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );
	$css = preg_replace( '/0 0 0 0/', '0', $css );
	$css = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css );

	return trim( $css );
}

/**
 * Helper function to check if we're on a WooCommerce page.
 *
 * @since  1.0.0
 *
 * @link   https://docs.woocommerce.com/document/conditional-tags/
 *
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
