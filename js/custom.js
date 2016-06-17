/* global WPNepalBlogScreenReaderText */

( function( $ ) {

	'use strict';

	$( document ).ready( function( $ ) {

		// Implement go to top.
		var $scrollup = $( '#btn-scrollup' );
		if ( $scrollup.length > 0 ) {

			$( window ).scroll( function() {
				if ( $( this ).scrollTop() > 100 ) {
					$scrollup.fadeIn();
				} else {
					$scrollup.fadeOut();
				}
			});

			$scrollup.click( function() {
				$( 'html, body' ).animate( { scrollTop: 0 }, 600 );
				return false;
			});
		}

		// Mobile menu.
		$( '#menu-toggle' ).click( function() {
			$( '#site-header-menu' ).toggle( 'slow' );
		});

		function initMainNavigation( container ) {

			// Add dropdown toggle that display child menu items.
			container.find( '.menu-item-has-children > a' ).after( '<button class="dropdown-toggle" aria-expanded="false">' + WPNepalBlogScreenReaderText.expand + '</button>' );

			// Toggle buttons and submenu items with active children menu items.
			container.find( '.current-menu-ancestor > button' ).addClass( 'toggle-on' );
			container.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' );

			container.find( '.dropdown-toggle' ).click( function( e ) {
				var _this = $( this );
				e.preventDefault();
				_this.toggleClass( 'toggle-on' );
				_this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );
				_this.attr( 'aria-expanded', 'false' === _this.attr( 'aria-expanded' ) ? 'true' : 'false' );
				_this.html( _this.html() === WPNepalBlogScreenReaderText.expand ? WPNepalBlogScreenReaderText.collapse : WPNepalBlogScreenReaderText.expand );
			} );
		}

		// Trigger menu.
		initMainNavigation( $( '.main-navigation' ) );

	});
} )( jQuery );
