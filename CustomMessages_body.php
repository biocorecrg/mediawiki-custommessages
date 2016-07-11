<?php
if (!defined('MEDIAWIKI')) { die(-1); } 

class CustomMessages {

	public static function loadMessages( $parser, $frame, $args ) {

		$output = "";

		if ( isset( $args[0]) && !empty( $args[0] ) ) {

			$out = $parser->getOutput();
			$out->addModules( 'ext.CustomMessages' );
			// Add clasess 'custommessages' to body
			// Add source elemements
			$source = trim( $frame->expand( $args[0] ) );

			$format = "ini";

			if ( isset( $args[1]) && !empty( $args[1] ) ) {
				$format = trim( $frame->expand( $args[1] ) );
			}

			$output = "<span class='mw-custommessages' data-source='".$source."' data-format='".$format."'></span>";

		}

		return array( $output, 'noparse' => true, 'isHTML' => true );
	}

	public static function processMessages( $pagename, $format='ini' ) {

		$messages = array();

		$title = Title::newFromText( $pagename );
		$page = WikiPage::factory( $title );

		$content = $page->getContent();

		$model = $page->getContentModel();

		// TODO, handling depending on content model

		if ( $format == 'ini' ) {

			$wikitext = $content->getNativeData();
			$lines = explode( "\n", $wikitext ) ;;
		
			foreach ( $lines as $line ) {
				if ( ! empty( $line ) ) {
					$parts = explode( "=", $line );

					if ( sizeof( $parts ) > 1 ) {
						$key = trim( $parts[0] );
						$value = trim( $parts[1] );

						$messages[ self::formatKey( $key ) ] = $value;
					}
				}
			}
		}
		
		return $messages;

	}

	private static function formatKey( $string ) {

		$string = strtolower( $string );
		$string = str_replace( " ", "_", $string);
		$string = str_replace( ":", "-", $string);

		return $string;
	}

}
