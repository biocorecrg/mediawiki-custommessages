/* jshint strict:true, browser:true */
( function () {
	'use strict';

	$( function () {

		$( '.mw-custommessages' ).each( function () {
			var $source = $( this );

			var source = $source.data( 'source' );
			var format = $source.data( 'format' ) || 'ini';

			if ( source ) {
				// We assume here split by ,
				String( source ).split( ',' ).forEach( function ( pagename ) {

					// API call here
					callCustomMessagesApi( pagename, format ).then( function ( response ) {
						if ( response && response.custommsg && response.custommsg.messages ) {
							modifyDOMwithMessages( response.custommsg.messages );
						}
					}, function () {
						mw.log.error( 'CustomMessages: API request failed for ' + pagename );
					} );
				} );
			}
		} );
	} );

	function callCustomMessagesApi( pagename, format ) {
		var api = new mw.Api();
		return api.get( {
			action: 'custommsg',
			source: pagename,
			'format-source': format
		} );
	}

	function modifyDOMwithMessages( msgSet ) {

		$( '.mw-custommessages-value' ).each( function () {

			var $el = $( this );
			var msg = $el.data( 'msg' );
			var output = $el.data( 'output' ) || 'append';

			if ( msg && Object.prototype.hasOwnProperty.call( msgSet, msg ) ) {

				// Flexible handling here
				if ( output === 'append' ) {
					$el.append( msgSet[ msg ] );
				} else if ( output !== '' ) {
					$el.attr( output, msgSet[ msg ] );
				}
			}
		} );
	}

}() );
