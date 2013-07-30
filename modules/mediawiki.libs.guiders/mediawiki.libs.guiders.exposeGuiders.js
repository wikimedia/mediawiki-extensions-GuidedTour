/*global guiders: false */
( function ( mw ) {

	/* This is in the same module as the Guiders code.  Capture it
	 * in mw.libs
	 * (per https://www.mediawiki.org/wiki/Manual:Coding_conventions/JavaScript#Globals)
	 * before we leave the module/anonymous function.
	 *
	 * It is not actually global in production mode; that just suppresses an
	 * inapplicable jshint warning on this file.
	 */
	mw.libs.guiders = guiders;
}( mediaWiki ) );
