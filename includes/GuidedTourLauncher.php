<?php

namespace MediaWiki\Extension\GuidedTour;

use MediaWiki\Context\RequestContext;
use MediaWiki\Json\FormatJson;
use MediaWiki\Output\OutputPage;

/**
 * Allows server-side launching of tours (without the URL parameter).
 */
class GuidedTourLauncher {
	/**
	 * State used to tell the client to directly launch tours using a client-side $wg
	 *
	 * @var array|null
	 */
	protected static $directLaunchState = null;

	// This matches the format used on the client-side (e.g.
	// mw.guidedTour.internal.getInitialUserStateObject,
	// mw.guidedTour.launchTourFromUserState, etc.

	/**
	 * Get new state from old state.  The state describes the user's progress
	 * in the tour, and which step they are expected to see next.
	 *
	 * @param array|null $oldState Previous state
	 * @param string $tourName Tour name
	 * @param string $step Step to start at
	 * @return array New state
	 */
	protected static function getNewState( $oldState, $tourName, $step ) {
		$newState = $oldState;

		if ( $newState === null ) {
			$newState = [];
		}

		$newState = array_replace_recursive( $newState, [
			'version' => 1,
			'tours' => [
				$tourName => [
					'step' => $step,
				],
			]
		] );

		return $newState;
	}

	/**
	 * Adds a tour to the cookie
	 *
	 * @param string|null $oldCookieValue Previous value of cookie
	 * @param string $tourName Tour name
	 * @param string $step Step to start at
	 * @return string Value of new cookie
	 */
	public static function getNewCookie( $oldCookieValue, $tourName, $step ) {
		if ( $oldCookieValue == null ) {
			$oldCookieValue = '{}';
		}

		$oldState = FormatJson::decode( $oldCookieValue, true );
		if ( $oldState === null ) {
			$oldState = [];
		}

		$newState = self::getNewState( $oldState, $tourName, $step );

		return FormatJson::encode( $newState );
	}

	/**
	 * Sets a tour to auto-launch on this view
	 *
	 * @param string $tourName Name of tour to launch
	 * @param string $step Step to navigate to
	 */
	public static function launchTour( $tourName, $step ) {
		$context = RequestContext::getMain();

		self::$directLaunchState = self::getNewState(
			self::$directLaunchState,
			$tourName,
			$step
		);

		Hooks::addTour( $context->getOutput(), $tourName );
	}

	/**
	 * Export data to client-side via mw.config (for use by ext.guidedTour.lib).
	 *
	 * @param array &$vars Array of request-specific JavaScript config variables
	 * @param OutputPage $out
	 */
	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $out ) {
		if ( self::$directLaunchState !== null ) {
			$vars['wgGuidedTourLaunchState'] = self::$directLaunchState;
		}
	}

	/**
	 * Sets a tour to auto-launch on this view using a cookie.
	 *
	 * @param string $tourName Name of tour to launch
	 * @param string $step Step to navigate to
	 */
	public static function launchTourByCookie( $tourName, $step ) {
		$context = RequestContext::getMain();

		$request = $context->getRequest();
		$oldCookie = $request->getCookie( Hooks::COOKIE_NAME );
		$newCookie = self::getNewCookie( $oldCookie, $tourName, $step );
		$request->response()->setCookie( Hooks::COOKIE_NAME, $newCookie, 0, [
			'httpOnly' => false,
		] );

		Hooks::addTour( $context->getOutput(), $tourName );
	}
}
