<?php
/**
 * CustomMessages — legacy entry point.
 *
 * Registration now lives in extension.json. Load the extension with:
 *
 *     wfLoadExtension( 'CustomMessages' );
 *
 * This file is kept only for backwards compatibility with installs that still
 * use require_once "$IP/extensions/CustomMessages/CustomMessages.php".
 */

if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'CustomMessages' );
	return;
}

die( 'This version of the CustomMessages extension requires MediaWiki 1.43 or later. '
	. 'Use wfLoadExtension( "CustomMessages" ) instead.' );
