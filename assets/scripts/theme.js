/**
 * Theme custom JavaScript.
 */

( function ( document, $ ) {

	'use strict';

	$( document ).ready(function () {

		// Add large letter to title.
		var title = $( 'h1' ).text().charAt( 0 );
		$( '.site-inner' ).append( '<span class="letter">' + title + '</span>' );

	} );

	// Add shrink class to header on scroll.
	$( window ).scroll( function () {

		var scroll = $( window ).scrollTop();
		var header = $( '.site-header' ).outerHeight();
		if (scroll >= header) {
			$( '.site-header' ).addClass( 'shrink' );
		} else {
			$( '.site-header' ).removeClass( 'shrink' );
		}
	});

	// Add wrap to portfolio item title.
	$( '.listing-item .title' ).wrap( '<span class="fade-in"></span>' );

} )( document, jQuery );
