/**
 * GuidedTour internal API
 *
 * For use only in mw.guidedTour.lib.js, ext.guidedTour.js, and unit tests of the internal
 * API.
 *
 * Will change without notice.
 *
 * Maintainer:
 *
 * @author Matt Flaschen <mflaschen@wikimedia.org>
 * @author Ori Livneh <ori@wikimedia.org>
 *
 * @class mw.guidedTour
 * @singleton
 */
( function ( mw, $ ) {
	var internal;

	mw.guidedTour = {
		internal: {
			/**
			 * Returns a promise that waits for all input deferreds.
			 *
			 * This will resolve if all of the input deferreds resolve
			 * successfully.
			 *
			 * It will reject if any of them fail (reject).
			 *
			 * However, in either case it waits until all input deferreds are
			 * completed (either resolved or rejected).
			 *
			 * @param {Array} deferreds array of deferreds to wait for
			 *
			 * @return {Promise} promise behaving as above
			 */
			alwaysWaitForAll: function ( deferreds ) {
				var dfd, unresolved, allSucceeded, i;

				function always() {
					unresolved--;
					if ( unresolved === 0 ) {
						if ( allSucceeded ) {
							dfd.resolve();
						} else {
							dfd.reject();
						}
					}
				}

				function fail() {
					allSucceeded = false;
				}

				dfd = $.Deferred();
				unresolved = deferreds.length;
				allSucceeded = true;
				for ( i = 0; i < deferreds.length; i++ ) {
					// First, if it fails we mark allSucceeded false.
					deferreds[i].fail( fail );
					// Then, we run the always handler regardless.
					deferreds[i].always( always );
				}

				return dfd.promise();
			},

			/**
			 * Gets the tour module name.  This does not guarantee there is such a module.
			 *
			 * @private
			 *
			 * @param {string} tourName Tour name
			 *
			 * @return {string} Tour module name
			 */
			getTourModuleName: function ( tourName ) {
				return 'ext.guidedTour.tour.' + tourName;
			},

			/**
			 * Loads an extension-defined tour
			 *
			 * @param {string} tourName name of tour to load
			 *
			 * @return {Promise} Promise that resolves on successful load and
			 *   rejects on failure.
			 */
			loadExtensionTour: function ( tourName ) {
				var dfd, tourModuleName;

				dfd = $.Deferred();
				tourModuleName = internal.getTourModuleName( tourName );
				mw.loader.using( tourModuleName,
					function () {
						 dfd.resolve();
					}, function ( err, dependencies ) {
						mw.log( 'Failed to load tour ', tourModuleName,
							'as module. err: ', err, ', dependencies: ',
							dependencies );
						dfd.reject();
					} );

				return dfd.promise();
			},

			/**
			 * Loads a tour from the MW namespaces
			 *
			 * @param {string} tourName name of tour to load
			 *
			 * @return {Promise} Promise that resolves on successful load and
			 *   rejects on failure.
			 */
			loadOnWikiTour: function ( tourName ) {
				var MW_NS_TOUR_PREFIX = 'MediaWiki:Guidedtour-tour-',
					onWikiTourUrl, dfd, title;

				dfd = $.Deferred();
				title = MW_NS_TOUR_PREFIX + tourName + '.js';

				onWikiTourUrl = mw.config.get( 'wgScript' ) + '?' + $.param( {
					title: title,
					action: 'raw',
					ctype: 'text/javascript'
				} );
				mw.log( 'Attempting to load on-wiki tour from ', onWikiTourUrl );

				$.getScript( onWikiTourUrl )
					.done( function ( script ) {
						// missing raw requests give 0 length document and 200 status not 404
						if ( script.length === 0 ) {
							mw.log( 'Tour page \'' + title + '\' is empty. Does the page exist?' );
							dfd.reject();
						}
						else {
							dfd.resolve();
						}
					} )
					.fail( function ( jqXHR, settings, exception ) {
						var message = 'Failed to load tour ' + tourName + ' from \'' + title + '\'';
						if ( exception ) {
							mw.log( message, exception );
						} else {
							mw.log( message );
						}
						dfd.reject();
					} );

				return dfd.promise();
			},

			/**
			 * Loads a tour.  If there is an extension-defined tour with
			 * the name, it will attempt to load that.  Otherwise, it will try
			 * to load an on-wiki tour
			 *
			 * @param {string} tourName name of tour to load
			 *
			 * @return {Promise} Promise that resolves on successful load andx
			 *   rejects on failure.
			 */
			loadTour: function ( tourName ) {
				var tourModuleName;

				tourModuleName = internal.getTourModuleName( tourName );
				if ( mw.loader.getState( tourModuleName ) !== null ) {
					return internal.loadExtensionTour( tourName );
				} else {
					mw.log( tourModuleName,
						' is not registered, probably because it is not extension-defined.' );
					return internal.loadOnWikiTour( tourName );
				}
			},

			/**
			 * Loads multiple tours
			 *
			 * @param {Array} tourNames array of tour names to load
			 *
			 * @return {Promise} Promise.  It will resolve if all attempts
			 *   succeed, and reject if any fail.  Either way, it will wait
			 *   until all load attempts are complete.
			 */
			loadMultipleTours: function ( tourNames ) {
				var loadDeferreds = $.map ( tourNames, function ( name) {
					return internal.loadTour( name );
				} );

				return internal.alwaysWaitForAll( loadDeferreds );
			}
		}
	};

	internal = mw.guidedTour.internal;
}( mediaWiki, jQuery ) );
