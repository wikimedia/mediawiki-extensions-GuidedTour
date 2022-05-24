<?php

namespace MediaWiki\Extension\GuidedTour;

use ExtensionRegistry;
use FormatJson;
use MediaWiki\ResourceLoader as RL;
use MediaWiki\ResourceLoader\ResourceLoader;
use OutputPage;
use Skin;
use Title;

/**
 * Use a hook to include this extension's functionality in pages
 * (if the page is called with a tour)
 *
 * @file
 * @author Terry Chay tchay@wikimedia.org
 * @author Matthew Flaschen mflaschen@wikimedia.org
 * @author Luke Welling lwelling@wikimedia.org
 */

class Hooks {
	// Tour cookie name.  It will be prefixed automatically.
	public const COOKIE_NAME = '-mw-tour';

	private const TOUR_PARAM = 'tour';

	/**
	 * ResourceLoader callback that adds the page name of a GuidedTour local
	 * documentation page, to demonstrate showing tour content from pages. This is
	 * a hack pending forcontent messages: https://phabricator.wikimedia.org/T27349
	 *
	 * If the page does not exist, it will not be set.
	 *
	 * @param RL\Context $context
	 * @return array
	 */
	public static function getHelpGuiderUrl( RL\Context $context ) {
		$data = [];

		$pageName = $context->msg( 'guidedtour-help-guider-url' )
			->inContentLanguage()->plain();
		$pageTitle = Title::newFromText( $pageName );
		if ( $pageTitle !== null && $pageTitle->exists() ) {
			$data['pageName'] = $pageName;
		}

		return $data;
	}

	/**
	 * Parses tour cookie, returning an array of tour names (empty if there is no
	 * cookie or the format is invalid)
	 *
	 * Example cookie.  This happens to have multiple tours, but cookies with any
	 * number of tours are accepted:
	 *
	 * {
	 * 	version: 1,
	 * 	tours: {
	 * 		firsttour: {
	 * 			step: 4
	 * 		},
	 * 		secondtour: {
	 * 			step: 2
	 * 		},
	 * 		thirdtour: {
	 * 			step: 3,
	 * 			firstArticleId: 38333
	 * 		}
	 * 	}
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

		return [];
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
	public static function addTour( $out, $tourName ) {
		$isUserJsAllowed = $out->getAllowedModules( RL\Module::TYPE_SCRIPTS )
			>= RL\Module::ORIGIN_USER_INDIVIDUAL;

		// Exclude '-' because MediaWiki message keys use it as a separator after the tourname.
		// Exclude '.' because module names use it as a separator.
		// "User JS" refers to on-wiki JavaScript. In theory we could still add
		// extension-defined tours, but it's more conservative not to.
		if ( $isUserJsAllowed && $tourName !== null && strpbrk( $tourName, '-.' ) === false ) {
			$tourModuleName = "ext.guidedTour.tour.$tourName";
			if ( $out->getResourceLoader()->getModule( $tourModuleName ) ) {
				// Add the tour itself for extension-defined tours.
				$out->addModules( $tourModuleName );
			} else {
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
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/BeforePageDisplay
	 *
	 * @param OutputPage $out OutputPage object
	 * @param Skin $skin Skin being used.
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
			$cookieValue = $request->getCookie( self::COOKIE_NAME );
			$tours = self::getTourNames( $cookieValue );
			foreach ( $tours as $tourName ) {
				self::addTour( $out, $tourName );
			}
		}

		return true;
	}

	/**
	 * Registers VisualEditor tour if VE is installed
	 *
	 * @param ResourceLoader &$resourceLoader
	 * @return true
	 */
	public static function onResourceLoaderRegisterModules( &$resourceLoader ) {
		if ( ExtensionRegistry::getInstance()->isLoaded( 'VisualEditor' ) ) {
			$resourceLoader->register(
				'ext.guidedTour.tour.firsteditve',
				[
					'scripts' => 'tours/firsteditve.js',
					'localBasePath' => __DIR__ . '/../modules',
					'remoteExtPath' => 'GuidedTour/modules',
					'dependencies' => 'ext.guidedTour',
					'messages' => [
						'editsection',
						'publishchanges',
						'guidedtour-tour-firstedit-edit-page-title',
						'guidedtour-tour-firsteditve-edit-page-description',
						'guidedtour-tour-firstedit-edit-section-title',
						'guidedtour-tour-firsteditve-edit-section-description',
						'guidedtour-tour-firstedit-save-title',
						'guidedtour-tour-firsteditve-save-description'
					]
				]
			);
		}

		return true;
	}

	/**
	 * @param array &$redirectParams
	 * @return bool
	 */
	public static function onRedirectSpecialArticleRedirectParams( &$redirectParams ) {
		array_push( $redirectParams, self::TOUR_PARAM, 'step' );

		return true;
	}
}
