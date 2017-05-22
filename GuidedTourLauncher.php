<?php

/**
 * Allows server-side launching of tours (without the URL parameter).
 */
class GuidedTourLauncher {
	/**
	 * Adds a tour to the cookie
	 *
	 * @param {string|null} $oldCookieValue Previous value of cookie
	 * @param {string} $tourName Tour name
	 * @param {string} $step Step to start at
	 * @return {string} Value of new cookie
	 */
	public static function getNewCookie( $oldCookieValue, $tourName, $step ) {
		if ( $oldCookieValue == null ) {
			$oldCookieValue = '{}';
		}

		$newCookie = FormatJson::decode( $oldCookieValue, true );
		if ( $newCookie === null ) {
			$newCookie = [];
		}

		$newCookie = array_replace_recursive( $newCookie, [
			'version' => 1,
			'tours' => [
				$tourName => [
					'step' => $step,
				],
			]
		] );

		return FormatJson::encode( $newCookie );
	}

	/**
	 * Sets a tour to auto-launch on this view using a cookie.
	 */
	public static function launchTourByCookie( $tourName, $step ) {
		global $wgOut, $wgRequest;

		$oldCookie = $wgRequest->getCookie( GuidedTourHooks::COOKIE_NAME );
		$newCookie = self::getNewCookie( $oldCookie, $tourName, $step );
		$wgRequest->response()->setCookie( GuidedTourHooks::COOKIE_NAME, $newCookie, 0, [
			'httpOnly' => false,
		] );

		GuidedTourHooks::addTour( $wgOut, $tourName );
	}
}
