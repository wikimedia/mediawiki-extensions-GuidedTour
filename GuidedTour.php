<?php
/**
 * This extension allows pages to add a popup guided tour to help new users
 * it is basd on Guiders.js from Optimizely
 *
 * @file
 * @author Luke Welling
 *
 */

/**
 * Prevent a user from accessing this file directly and provide a helpful
 * message explaining how to install this extension.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install the Guided Tour extension, put the following line in your
LocalSettings.php file:
require_once( "\$IP/extensions/GuidedTour/GuidedTour.php" );
EOT;
	exit( 1 );
}

// Find the full directory path of this extension
$dir =  __DIR__ . DIRECTORY_SEPARATOR;
$wgAutoloadClasses['GuidedTourHooks'] = $dir . 'GuidedTourHooks.php';

$wgHooks['BeforePageDisplay'][] = 'GuidedTourHooks::onBeforePageDisplay';

// Extension credits that will show up on Special:Version
$wgExtensionCredits[ 'other' ][] = array(
	'path' => __FILE__,
	'name' => 'GuidedTour',
	'author' =>'Luke Welling, Terry Chay',
	'url' => 'https://www.mediawiki.org/wiki/Extension:GuidedTour',
	'description' => 'guided-tour-desc',
	'version'  => 1.0,
);

$wgResourceModules['GuidedTour'] = array(
	'styles' => array( 'ext.guidedtour.guiders.css', ),
	'scripts' => array( 'externals/ext.guidedtour.guiders.js', 'ext.guidedtour.guidedTour.js', ),
	'localBasePath' => $dir . 'modules',
	'remoteExtPath' => 'GuidedTour/modules',
//	'dependencies'  => array( 'ext.Experiments.lib', )
);
