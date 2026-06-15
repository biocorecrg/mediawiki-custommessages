<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

use MediaWiki\MediaWikiServices;

class CustomMessages {

	/**
	 * ParserFirstCallInit hook handler. Registers the {{#CustomMsg}} parser function.
	 *
	 * @param Parser $parser
	 * @return bool
	 */
	public static function onParserFirstCallInit( $parser ) {
		$parser->setFunctionHook( 'CustomMsg', [ self::class, 'loadMessages' ], Parser::SFH_OBJECT_ARGS );
		return true;
	}

	public static function loadMessages( $parser, $frame, $args ) {

		$output = "";

		if ( isset( $args[0] ) && !empty( $args[0] ) ) {

			$out = $parser->getOutput();
			$out->addModules( [ 'ext.CustomMessages' ] );
			// Add source element. The JavaScript module reads data-source / data-format.
			$source = trim( $frame->expand( $args[0] ) );

			$format = "ini";

			if ( isset( $args[1] ) && !empty( $args[1] ) ) {
				$format = trim( $frame->expand( $args[1] ) );
			}

			$output = Html::element( 'span', [
				'class' => 'mw-custommessages',
				'data-source' => $source,
				'data-format' => $format,
			] );

		}

		return [ $output, 'noparse' => true, 'isHTML' => true ];
	}

	public static function processMessages( $pagename, $format = 'ini' ) {

		$messages = [];

		$title = Title::newFromText( $pagename );

		if ( !$title || !$title->exists() ) {
			return $messages;
		}

		$page = MediaWikiServices::getInstance()->getWikiPageFactory()->newFromTitle( $title );

		$content = $page->getContent();

		// TODO, handling depending on content model
		if ( !$content instanceof TextContent ) {
			return $messages;
		}

		if ( $format == 'ini' ) {

			$wikitext = $content->getText();
			$lines = explode( "\n", $wikitext );

			foreach ( $lines as $line ) {
				if ( !empty( $line ) ) {
					$parts = explode( "=", $line );

					if ( count( $parts ) > 1 ) {
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
		$string = str_replace( " ", "_", $string );
		$string = str_replace( ":", "-", $string );

		return $string;
	}

}
