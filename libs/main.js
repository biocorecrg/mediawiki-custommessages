/* jshint strict:true, browser:true */
( function( $, mw ) {

	$(document).ready(function(){

		$(".mw-custommessages").each( function( iter ) {
			var selector = this;
		
			var source = $(selector).data('source');
			var format = $(selector).data('format');

			if ( source ) {
				// We assume here split by ,
				var pagenames = source.split(",");
				for (var i = 0; i < pagenames.length; i++) {
				
					// API Call here
					callCustomMessagesApi( pagenames[i], format, function( response ) {
						if ( response && response['custommsg'] && response['custommsg']['messages'] ) {
							modifyDOMwithMessages( source, response['custommsg']['messages'] );
						}
					});
				}
			}
		});
	});

	function callCustomMessagesApi( pagename, format, callback ) {
	
		var params = {};
		params['source'] = pagename;
		params['format-source'] = format;
		params['format'] = "json";
		params['action'] = "custommsg";
	
		var posting = $.get( wgScriptPath + "/api.php", params );
		posting.done(function( data ) {
			callback( data );
		}).fail( function( data ) {
			callback( null );
			console.log("Error!");
		});
	}
	
	function modifyDOMwithMessages( source, msgSet ) {
	
		$(".mw-custommessages-value").each( function( iter ) {
	
			var selector = this;
			var msg = $(selector).data('msg');
			var output = $(selector).data('output');
			if ( ! output ) {
				output = "append";
			}

			if ( msg ) {

				if ( msgSet.hasOwnProperty( msg ) ) {

					// Flexible handling here
					if ( output === 'append' ) {
						$(selector).append( msgSet[msg] );
					} else  {
						if ( output !== "" ) {
							$(selector).prop( output, msgSet[msg] );
						}
					}
				}
			}
		});
	}

} )( jQuery, mediaWiki );
