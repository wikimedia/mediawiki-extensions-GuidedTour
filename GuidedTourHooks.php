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
	/**
	 * Handler for BeforePageDisplay hook.
	 * @see http://www.mediawiki.org/wiki/Manual:Hooks/BeforePageDisplay
	 * @param $out OutputPage object
	 * @param $skin Skin being used.
	 * @return bool true in all cases
	 */
	public static function onBeforePageDisplay( $out, $skin ) {
		global $wgResourceModules;
		// test for tour enabled in url first
		$request = $out->getRequest();
		$tourName = $request->getVal('tour');
		/*
		  These are excluded because:
		  '-': For our MediaWiki namespace namespacing.
		  '.': It is used for module naming
		*/

		if( $tourName !== NULL && strpbrk( $tourName, '-.' ) === FALSE ) {
			$tourModuleName = "ext.guidedTour.tour.$tourName";
			if ( isset ( $wgResourceModules[$tourModuleName] ) ) {
				// Add the tour itself for built-in tours.
				$out->addModules($tourModuleName);
			} else {
				/*
				   Otherwise, add the main module, which attempts to import an
				   on-wiki tour.
				*/
				$out->addModules('ext.guidedTour');
			}
		}
		return true;
	}
}
