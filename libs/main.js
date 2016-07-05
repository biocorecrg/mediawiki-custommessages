/* jshint strict:true, browser:true */
( function( $, mw ) {

	$(document).ready(function(){

		$(".mw-custommessages").each( i, function() {
			var selector = this;

			var source = $(selector).data('source');

			if ( source ) {
				// We assume here split by ,
				var pagenames = source.split(",");
				for (var i = 0; i < pagenames.length; i++) {
					
					// API Call here
					callCustomMessagesApi( pagenames[i], function( msgSet ) {
						if ( msgSet ) {
							modifyDOMwithMessages( msgSet );
						}
					});
				}
			}
		});
	});

	function callCustomMessagesApi( pagename, callback ) {

		var params = {};
		params['source'] = pagename;
		params['action'] = "custommsg";

		var posting = $.get( wgScriptPath + "/api.php", params );
		posting.done(function( data ) {
			callback( data );
		}).fail( function( data ) {
			callback( null );
			console.log("Error!");
		});
	}

	function modifyDOMwithMessages( msgSet ) {

		$(".mw-custommessages-value").each( i, function() {

			var msg = $(selector).data('msg');
			if ( msg ) {
				if ( msgSet.hasOwnProperty( msg ) ) {
					// TODO: Do replacement here
				}
			}
		}
	}

} )( jQuery, mediaWiki );