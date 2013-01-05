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
	// Keep in sync with regex in ext.guidedTour.js
	const TOUR_ID_REGEX = '/^gt-([^-]+)-(\d+)$/';

	// Tour cookie name.  It will be prefixed, but this is handled correctly.
	const COOKIE_NAME = '-mw-tour';
	/*
	   XXX (mattflaschen, 2012-01-02):

	   wgGuidedTourHelpUrl and wgGuidedTourTestWikitextDescription are hacks pending
	   forcontent messages:
	   https://bugzilla.wikimedia.org/show_bug.cgi?id=25349
	*/
	/**
	 * MakeGlobalVariablesScript hook.
	 * Add config vars to mw.config.
	 *
	 * @param $vars array
	 * @param $out OutputPage output page
	 * @return bool
	 */
	public static function onMakeGlobalVariablesScript( &$vars, $out ) {
		$vars['wgGuidedTourHelpUrl'] =
			wfMessage( 'guidedtour-help-url' )->inContentLanguage()->plain();

		$vars['wgGuidedTourTestWikitextDescription'] =
			wfMessage( 'guidedtour-tour-test-wikitext-description' )->parse();

		return true;
	}

	/**
	 * Parses tour cookie
	 *
	 * @private
	 *
	 * @param WebRequest $request: a request
	 *
	 * @return array|null array if cookie exists and could be parsed, null otherwise
	 */
	public static function parseTourCookie( $request ) {
		$cookie = $request->getCookie( self::COOKIE_NAME );
		if ( $cookie !== null ) {
			$isMatch = preg_match( self::TOUR_ID_REGEX, $cookie, $matches );
			if ( $isMatch !== false ) {
				return array(
					'name' => $matches[1],
					'step' => $matches[2],
				);
			}
		}

		return null;
	}

	/**
	 * Adds a built-in or wiki tour.
	 *
	 * If the built-in one exists as a module, it will add that.
	 *
	 * Otherwise, it will add the general guided tour module, which will take care of
	 * loading the on-wiki tour
	 *
	 * It will not attempt to add tours that violate the naming rules.
	 *
	 * @param OutputPage $out: output page
	 * @param string $tourName: the tour name, such as 'gettingstarted'
	 *
	 * @return true if a module was added, false otherwise
	 */
	private static function addTour( $out, $tourName ) {
		global $wgResourceModules;

		// Exclude '-' because MediaWiki message keys use it as a separator after the tourname.
		// Exclude '.' because module names use it as a separator.
		if ( $tourName !== NULL && strpbrk( $tourName, '-.' ) === FALSE ) {
			$tourModuleName = "ext.guidedTour.tour.$tourName";
			if ( isset ( $wgResourceModules[$tourModuleName] ) ) {
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
		global $wgResourceModules;
		// test for tour enabled in url first
		$request = $out->getRequest();
		$queryTourName = $request->getVal('tour');
		if ( $queryTourName !== null ) {
			self::addTour( $out, $queryTourName );
		} else {
			$tourInfo = self::parseTourCookie( $out->getRequest() );
			if ( $tourInfo !== null ) {
				self::addTour( $out, $tourInfo['name'] );
			}
		}

		return true;
	}
}
