<?php

/**
 * Use a hook to include this extension's functionality in pages
 * (if the page is called with a tour)
 *
 * @file
 * @author Terry Chay tchay@wikimedia.org
 * @author Matthew Flaschen mflaschen@wikimedia.org
 * @author Luke Welling lwelling@wikimedia.org
 *
 */

class GuidedTourHooks {
	// Tour cookie name.  It will be prefixed automatically.
	const COOKIE_NAME = '-mw-tour';

	const TOUR_PARAM = 'tour';

	/**
	 * Add dynamic VE messages we care about to firsteditve tour.
	 *
	 * Extension function ($wgExtensionFunctions)
	 *
	 * @see VisualEditorHooks::onSetup
	 */
	public static function onSetup() {
		global $wgResourceModules, $wgVisualEditorTabMessages;

		// This can be extended if we need to support customization of
		// additional types, such as 'edit' or 'editsection'.
		$firstEditVeTabAppendixTypes = array(
			'editappendix',
			'editsectionappendix',
		);

		foreach( $firstEditVeTabAppendixTypes as $messageType ) {
			$messageKey = $wgVisualEditorTabMessages[$messageType];
			if ( $messageKey !== null ) {
				// ResourceLoaderFileModule strips duplicates
				$wgResourceModules['ext.guidedTour.tour.firsteditve']['messages'][] = $messageKey;
			}
		}
	}

	/*
	   XXX (mattflaschen, 2012-01-02):

	   wgGuidedTourHelpGuiderUrl is a hack pending forcontent messages:
	   https://bugzilla.wikimedia.org/show_bug.cgi?id=25349
	*/
	/**
	 * Add static config vars to startup module that will be exposed via mw.config.
	 *
	 * No value added here can depend on the page name, user, or other request-specific
	 * data.
	 *
	 * @param array $vars Associative array of config variables
	 * @return bool
	 */
	public static function onResourceLoaderGetConfigVars( &$vars ) {
		$vars['wgGuidedTourHelpGuiderUrl'] =
			wfMessage( 'guidedtour-help-guider-url' )->inContentLanguage()->plain();

		return true;
	}

	/**
	 * Parses tour cookie, returning an array of tour names (empty if there is no
	 * cookie or the format is invalid)
	 *
	 * Example cookie.  This happens to have multiple tours, but cookies with any
	 * number of tours are accepted:
	 *
	 * {
	 *	version: 1,
	 *	tours: {
	 *		firsttour: {
	 *			step: 4
	 *		},
	 *		secondtour: {
	 *			step: 2
	 *		},
	 *		thirdtour: {
	 *			step: 3,
	 *			firstArticleId: 38333
	 *		}
	 *	}
	 * }
	 *
	 * This only supports new-style cookies.  Old cookies will be converted on the
	 * client-side, then the tour module will be loaded.
	 *
	 * @param string $cookieValue cookie value
	 *
	 * @return array array of tour names, empty if no cookie or cookie is invalid
	 */
	public static function getTourNames( $cookieValue ) {
		if ( $cookieValue !== null ) {
			$parsed = FormatJson::decode( $cookieValue, true );
			if ( isset( $parsed['tours'] ) ) {
				return array_keys( $parsed['tours'] );
			}
		}

		return array();
	}

	/**
	 * Adds a built-in or wiki tour.
	 *
	 * If user JS is disallowed on this page, it does nothing.
	 *
	 * If the built-in one exists as a module, it will add that.
	 *
	 * Otherwise, it will add the general guided tour module, which will take care of
	 * loading the on-wiki tour
	 *
	 * It will not attempt to add tours that violate the naming rules.
	 *
	 * @param OutputPage $out output page
	 * @param string $tourName the tour name, such as 'gettingstarted'
	 *
	 * @return bool true if a module was added, false otherwise
	 */
	private static function addTour( $out, $tourName ) {
		global $wgResourceModules;

		$isUserJsAllowed = $out->getAllowedModules( ResourceLoaderModule::TYPE_SCRIPTS ) >= ResourceLoaderModule::ORIGIN_USER_INDIVIDUAL;

		// Exclude '-' because MediaWiki message keys use it as a separator after the tourname.
		// Exclude '.' because module names use it as a separator.
		// "User JS" refers to on-wiki JavaScript. In theory we could still add
		// extension-defined tours, but it's more conservative not to.
		if ( $isUserJsAllowed && $tourName !== null && strpbrk( $tourName, '-.' ) === false ) {
			$tourModuleName = "ext.guidedTour.tour.$tourName";
			if ( isset( $wgResourceModules[$tourModuleName] ) ) {
				// Add the tour itself for extension-defined tours.
				$out->addModules( $tourModuleName );
			}
			else {
				/*
				  Otherwise, add the main module, which attempts to import an
				  on-wiki tour.
				*/
				$out->addModules( 'ext.guidedTour' );
			}

			return true;
		}

		return false;
	}

	/**
	 * Handler for BeforePageDisplay hook.
	 *
	 * Adds a tour-related module if possible.
	 *
	 * If the query parameter is set, it will use that.
	 * Otherwise, it will use the cookie if that exists.
	 *
	 * @see http://www.mediawiki.org/wiki/Manual:Hooks/BeforePageDisplay
	 *
	 * @param $out OutputPage object
	 * @param $skin Skin being used.
	 *
	 * @return bool true in all cases
	 */
	public static function onBeforePageDisplay( $out, $skin ) {
		// test for tour enabled in url first
		$request = $out->getRequest();
		$queryTourName = $request->getVal( self::TOUR_PARAM );
		if ( $queryTourName !== null ) {
			self::addTour( $out, $queryTourName );
		} else {
			// TODO (mattflaschen, 2013-06-02): Should we add both the query
			// tour and the cookie ones, rather than letting the query take precedence?
			$cookieValue = $request->getCookie( self::COOKIE_NAME );
			$tours = self::getTourNames( $cookieValue );
			foreach ( $tours as $tourName ) {
				self::addTour( $out, $tourName );
			}
		}

		return true;
	}

	/**
	 * @param array &$testModules
	 * @param ResourceLoader $resourceLoader
	 * @return bool
	 */
	public static function onResourceLoaderTestModules( &$testModules, &$resourceLoader ) {
		$testModules[ 'qunit' ][ 'ext.guidedTour.lib.tests' ] = array(
			'scripts' => array( 'tests/ext.guidedTour.lib.tests.js' ),
			'dependencies' => array( 'ext.guidedTour.lib' ),
			'localBasePath' => __DIR__,
			'remoteExtPath' => 'GuidedTour',
		);
		return true;
	}

	/**
	 * Registers PHPUnit tests
	 *
	 * @param array &$files test files
	 * @return bool always true
	 */
	public static function onUnitTestsList( &$files ) {
		$testDir = __DIR__ . '/tests';
		$files = array_merge( $files, glob( "$testDir/*Test.php" ) );
		return true;
	}

	/**
	 * @param $redirectParams array
	 * @return bool
	 */
	public static function onRedirectSpecialArticleRedirectParams( &$redirectParams ) {
		array_push( $redirectParams, self::TOUR_PARAM, 'step' );

		return true;
	}
}
