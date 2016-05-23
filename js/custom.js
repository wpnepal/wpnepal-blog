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

	});

} )( jQuery );