/* Kenya GH2 Map – tooltip interaction */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		var tt = document.getElementById( 'kgh2-tt' );
		if ( tt ) {
			document.querySelectorAll( '.kgh2-wrap .marker' ).forEach( function ( m ) {
				m.addEventListener( 'mouseenter', function () {
					document.getElementById( 'kgh2-tt-name' ).textContent = m.dataset.n || '';
					document.getElementById( 'kgh2-tt-prod' ).textContent = m.dataset.product || '';
					document.getElementById( 'kgh2-tt-stat' ).textContent = m.dataset.status || '';
					document.getElementById( 'kgh2-tt-size' ).textContent = m.dataset.size || '';
					document.getElementById( 'kgh2-tt-loc' ).textContent  = m.dataset.loc  || '';
					tt.classList.add( 'on' );
				} );

				m.addEventListener( 'mousemove', function ( e ) {
					tt.style.left = ( e.clientX + 16 ) + 'px';
					tt.style.top  = ( e.clientY - 16 ) + 'px';
				} );

				m.addEventListener( 'mouseleave', function () {
					tt.classList.remove( 'on' );
				} );
			} );
		}

		// Toggle legend panel on title click
		document.querySelectorAll( '.kgh2-wrap .panel' ).forEach( function ( panel ) {
			var title = panel.querySelector( '.panel-title' );
			if ( ! title ) return;

			title.addEventListener( 'click', function () {
				panel.classList.toggle( 'collapsed' );
			} );
		} );
	} );
}() );
