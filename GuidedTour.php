<?php
/**
 * This extension allows pages to add a popup guided tour to help new users
 * It is partly based on the Guiders JavaScript library, originally developed by Optimizely.
 *
 * There have also been further changes to Guiders in conjunction with this extension.
 *
 * @file
 * @author Terry Chay tchay@wikimedia.org
 * @author Matthew Flaschen mflaschen@wikimedia.org
 * @author Luke Welling lwelling@wikimedia.org
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
$dir = __DIR__ . DIRECTORY_SEPARATOR;
$wgAutoloadClasses += array(
	'GuidedTourHooks' => $dir . 'GuidedTourHooks.php',
	'ResourceLoaderGuidedTourSiteStylesModule' =>
	$dir . 'includes/ResourceLoaderGuidedTourSiteStylesModule.php',
);

$wgHooks['BeforePageDisplay'][] = 'GuidedTourHooks::onBeforePageDisplay';
$wgHooks['MakeGlobalVariablesScript'][] = 'GuidedTourHooks::onMakeGlobalVariablesScript';
$wgHooks['ResourceLoaderTestModules'][] = 'GuidedTourHooks::onResourceLoaderTestModules';
$wgHooks['UnitTestsList'][] = 'GuidedTourHooks::onUnitTestsList';
$wgHooks['RedirectSpecialArticleRedirectParams'][] = 'GuidedTourHooks::onRedirectSpecialArticleRedirectParams';

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'GuidedTour',
	'author' => array('Terry Chay', 'Matthew Flaschen', 'Luke Welling',),
	'url' => 'https://www.mediawiki.org/wiki/Extension:GuidedTour',
	'descriptionmsg' => 'guidedtour-desc',
	'version'  => '1.1.0',
);

// Schemas
$wgEventLoggingSchemas['GuidedTourGuiderImpression'] = 8694395;
$wgEventLoggingSchemas['GuidedTourGuiderHidden'] = 8690549;
$wgEventLoggingSchemas['GuidedTourButtonClick'] = 8690550;
$wgEventLoggingSchemas['GuidedTourInternalLinkActivation'] = 8690553;
$wgEventLoggingSchemas['GuidedTourExternalLinkActivation'] = 8690560;
$wgEventLoggingSchemas['GuidedTourExited'] = 8690566;

$guidersPath = 'modules/mediawiki.libs.guiders';

// Modules
$wgResourceModules['mediawiki.libs.guiders'] = array(
	'styles' => 'mediawiki.libs.guiders.less',
	'scripts' => array(
		'mediawiki.libs.guiders.js',
	),
	'localBasePath' => $dir . $guidersPath,
	'remoteExtPath' => "GuidedTour/$guidersPath",
);

// TODO (mattflaschen, 2013-07-30): When the location of the rendering code
// is decided, this module can be merged to there.
$wgResourceModules['ext.guidedTour.styles'] = array(
	'styles' => array(
		'ext.guidedTour.less',
		'ext.guidedTour.animations.less'
	),
	'localBasePath' => $dir . 'modules',
	'remoteExtPath' => 'GuidedTour/modules',
	'dependencies' => array(
		'mediawiki.libs.guiders',
		// Ideally 'mediawiki.ui.button' should be added with addModuleStyles to
		// avoid duplication.
		// However, that wouldn't work if a tour is loaded dynamically on the client-side.
		'mediawiki.ui.button',
	),
);

// Depends on ext.guidedTour.styles
$wgResourceModules['ext.guidedTour.siteStyles'] = array(
	'class' => 'ResourceLoaderGuidedTourSiteStylesModule',
);

$wgResourceModules['ext.guidedTour.lib.internal'] = array(
	'scripts' => 'ext.guidedTour.lib.internal.js',
	'localBasePath' => $dir . 'modules',
	'remoteExtPath' => 'GuidedTour/modules',
);

$wgResourceModules['ext.guidedTour.lib'] = array(
	'scripts' => array(
		'ext.guidedTour.lib.TransitionEvent.js',
		'ext.guidedTour.lib.main.js',
		'ext.guidedTour.lib.EventLogger.js',
		'ext.guidedTour.lib.TransitionAction.js',
		'ext.guidedTour.lib.StepBuilder.js',
		'ext.guidedTour.lib.Step.js',
		'ext.guidedTour.lib.TourBuilder.js',
		'ext.guidedTour.lib.Tour.js',
	),
	'localBasePath' => $dir . 'modules/ext.guidedTour.lib',
	'remoteExtPath' => 'GuidedTour/modules/ext.guidedTour.lib',
	'dependencies' => array(
		'jquery.cookie',
		'jquery.json',
		'mediawiki.Title',
		'mediawiki.jqueryMsg',
		'mediawiki.libs.guiders',
		'mediawiki.user',
		'mediawiki.util',
		'schema.GuidedTourGuiderImpression',
		'schema.GuidedTourGuiderHidden',
		'schema.GuidedTourButtonClick',
		'schema.GuidedTourInternalLinkActivation',
		'schema.GuidedTourExternalLinkActivation',
		'schema.GuidedTourExited',
		'ext.guidedTour.lib.internal',
		'ext.guidedTour.siteStyles',
	),
	'messages' => array(
		'guidedtour-next-button',
		'guidedtour-okay-button',
	),
);

// Lightweight launcher module
$wgResourceModules['ext.guidedTour.launcher'] = array(
	'scripts' => 'ext.guidedTour.launcher.js',
	'localBasePath' => $dir . 'modules',
	'remoteExtPath' => 'GuidedTour/modules',
);

// This calls code in guidedTour.lib to attempt to launch a tour, based on the environment
// (currently query string and a cookie)
$wgResourceModules['ext.guidedTour'] = array(
	'scripts' => 'ext.guidedTour.js',
	'localBasePath' => $dir . 'modules',
	'remoteExtPath' => 'GuidedTour/modules',
	'dependencies' => 'ext.guidedTour.lib',
);


// Tour modules

// First edit to main namespace; for when VisualEditor is unavailable or disabled
$wgResourceModules['ext.guidedTour.tour.firstedit'] = array(
	'scripts' => 'firstedit.js',
	'localBasePath' => $dir . 'modules/tours',
	'remoteExtPath' => 'GuidedTour/modules/tours',
	'dependencies' => 'ext.guidedTour',
	'messages' => array(
		'editsection',
		'savearticle',
		'showpreview',
		'vector-view-edit',
		'guidedtour-tour-firstedit-edit-page-title',
		'guidedtour-tour-firstedit-edit-page-description',
		'guidedtour-tour-firstedit-edit-section-title',
		'guidedtour-tour-firstedit-edit-section-description',
		'guidedtour-tour-firstedit-preview-title',
		'guidedtour-tour-firstedit-preview-description',
		'guidedtour-tour-firstedit-save-title',
		'guidedtour-tour-firstedit-save-description',
	),
);

// First edit to main namespace; for when VisualEditor is available and enabled
$wgResourceModules['ext.guidedTour.tour.firsteditve'] = array(
	'scripts' => 'firsteditve.js',
	'localBasePath' => $dir . 'modules/tours',
	'remoteExtPath' => 'GuidedTour/modules/tours',
	'dependencies' => 'ext.guidedTour',
	'messages' => array(
		'editsection',
		'vector-view-edit',
		'visualeditor-toolbar-savedialog',
		'guidedtour-tour-firstedit-edit-page-title',
		'guidedtour-tour-firsteditve-edit-page-description',
		'guidedtour-tour-firstedit-edit-section-title',
		'guidedtour-tour-firsteditve-edit-section-description',
		'guidedtour-tour-firstedit-save-title',
		'guidedtour-tour-firsteditve-save-description',
	),
);

// Test tour as demonstration
$wgResourceModules['ext.guidedTour.tour.test'] = array(
	'scripts' => 'test.js',
	'localBasePath' => $dir . 'modules/tours',
	'remoteExtPath' => 'GuidedTour/modules/tours',
	'dependencies' => 'ext.guidedTour',
	'messages' => array(
		'portal',
		'guidedtour-help-url',
		'guidedtour-tour-test-testing',
		'guidedtour-tour-test-test-description',
		'guidedtour-tour-test-callouts',
		'guidedtour-tour-test-portal-description',
		'guidedtour-tour-test-mediawiki-parse',
		'guidedtour-tour-test-description-page',
		'guidedtour-tour-test-go-description-page',
		'guidedtour-tour-test-launch-tour',
		'guidedtour-tour-test-launch-tour-description',
		'guidedtour-tour-test-launch-using-tours',
	),
);

// Messages
$wgMessagesDirs['GuidedTour'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles += array(
	'GuidedTour' => $dir . 'GuidedTour.i18n.php',
);

// Extension function
$wgExtensionFunctions[] = 'GuidedTourHooks::onSetup';
