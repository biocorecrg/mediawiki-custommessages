<?php
if( !defined( 'MEDIAWIKI' ) ) {
	die("This file is an extension to the MediaWiki software and cannot be used standalone.\n");
}

//self executing anonymous function to prevent global scope assumptions
call_user_func( function() {

	# Parser functions for BioDB
	# Based on ExternalData
	$GLOBALS['wgExtensionCredits']['parserhook'][] = array(
			'path' => __FILE__,     // Magic so that svn revision number can be shown
			'name' => "CustomMessages",
			'description' => "Print custom messages via tooltips or other JavaScript enabled methods",
			'version' => '0.1.0', 
			'author' => array("Toniher"),
			'url' => "https://www.mediawiki.org/wiki/User:Toniher",
	);
	
	# Define a setup function
	$GLOBALS['wgHooks']['ParserFirstCallInit'][] = 'wfCustomMessagesParserFunction_Setup';
	# Add a hook to initialise the magic word
	$GLOBALS['wgHooks']['LanguageGetMagic'][]       = 'wfCustomMessagesParserFunction_Magic';
	
	
	# A var to ease the referencing of files
	$dir = dirname(__FILE__) . '/';
	$GLOBALS['wgAutoloadClasses']['CustomMessages'] = $dir . 'CustomMessages_body.php';
	# API Stuff
	$GLOBALS['wgAutoloadClasses']['ApiCustomMessages'] = dirname( __FILE__ ). '/CustomMessages.api.php';
	
	// api modules
	$GLOBALS['wgAPIModules']['custommsg'] = 'ApiCustomMessages';


	$GLOBALS['wgResourceModules']['ext.CustomMessages'] = array(
		'localBasePath' => dirname( __FILE__ ),
		'scripts' => array('libs/main.js' ),
		'styles' => array('styles/main.css'),
		'remoteExtPath' => 'CustomMessages'
	);

});

function wfBioDBParserFunction_Setup( &$parser ) {
	$parser->setFunctionHook( 'CustomMsg', 'BioDB::loadMessages', SFH_OBJECT_ARGS );
	return true;
}

function wfBioDBParserFunction_Magic( &$magicWords, $langCode ) {
	$magicWords['CustomMsg'] = array( 0, 'CustomMsg' );
	# unless we return true, other parser functions extensions won't get loaded.
	return true;
}



