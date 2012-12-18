 /**
  * Extension for Guided Tour for MediaWiki
  *
  * Based on a WordPress.com customized version of Optimize.ly's Guiders.js file.
  *
  * To use create a tour in /modules/tour then load a page with tour=TourName appended to the url
  * To see if it works index.php?tour=test is a start
  *
  * @author     Terry Chay <tchay@wikimedia.org>
  * @author     Matt Flaschen <mflaschen@wikimedia.org>
  * @author     Luke Welling <lwelling@wikimedia.org>
*/

( function ( window, document, jQuery, mw, guiders ) {
	'use strict';

	var gt = mw.guidedTour = mw.guidedTour || {};

	if (!gt.tourUrl) {
		gt.tourUrl = mw.config.get('wgScript') + '?title=MediaWiki:Guidedtour/';
	}

	function parseTourId( tourId ) {
		if ( typeof tourId !== 'string' ) {
			return null;
		}
		var TOUR_ID_REGEX = /^gt-([^-]+)-(\d+)$/;

		var tourMatch =	tourId.match( TOUR_ID_REGEX ), tourStep;
		if ( ! tourMatch ) {
			return null;
		}

		tourName = tourMatch[1];
		tourName = cleanTourName( tourName );
		tourStep = tourMatch[2];

		if ( tourName.length === 0) {
			return null;
		}

		return {
			name: tourName,
			step: tourMatch
		};
	}

	function stringifyTourId( tourInfo ) {
		if ( typeof tourInfo !== 'object' || tourInfo === null ) {
			return null;
		}

		return 'gt-' + tourInfo.name + '-' + tourInfo.step;
	}

	/**
	 * clean out path variables and the like in tour names
	 */
	function cleanTourName( tourName ) {
		return mw.util.rawurlencode( tourName.replace( /^(?:\.\.\/)+/, '' ) );
	};

	// tour is either in get string or cookie (prefer get string)
	var tourName = mw.util.getParamValue( 'tour' );
	var tourId, tourInfo;
	//clean out path variables
	if ( tourName ) {
		tourName = cleanTourName( tourName );
	}
	if ( tourName.length !== 0 ) {
		var step = mw.util.getParamValue( 'step' );
		if ( step === null || step === '' ) {
			step = '1';
		}
		tourId = stringifyTourId( {
			name: tourName,
			step: step
		} );
	} else {
		tourId = $.cookie('mw-tour');
		tourInfo = parseTourId(tourId);
		if ( tourInfo !== null ) {
			tourName = tourInfo.name;
		}
	}
	// Don't bother loading any more code if there isn't a tour going on
	if ( !tourId || !tourName ) {
		return;
	}

	/**
	 * mw.guidedTour.launchTour(): Load a tour javascript and launch a tour
	 */
	gt.launchTour = function ( tourName, tourId ) {
		if ( !tourId ) {
			tourId = stringifyTourId( {
				name: tourName,
				step: '1'
			} );
		}
		// append to request raw JS code without page markup
		var rawJS = '&action=raw&ctype=text/javascript';
		$.getScript( gt.tourUrl + tourName + '.js' + rawJS )
		.done( function ( script, textStatus ) {
			// missing raw requests give 0 length document and 200 status not 404
			if ( script.length < 1 ) {
				mw.log( 'Tour ' + tourName + ' is empty. Does the page exist?' );
			}
			else {
				// if we successfully loaded the tour
				guiders.resume(tourId);
			}
		})
		.fail( function ( jqxhr, settings, exception ) {
			mw.log( 'Failed to load tour ' + tourName );
		});
	};

	// load custom CSS from wiki page MediaWiki:Guidedtour-custom.css
        var cssUrl = gt.tourUrl + 'custom.css&action=raw&ctype=text/css';
	mw.loader.load(cssUrl, 'text/css');

	// launch the tour.
	gt.launchTour(tourName, tourId);

	// cookie the users when they are in the tour
	guiders.cookie = 'mw-tour';
	guiders.cookieParams = { path: '/' };
	// add x button to top right
	guiders._defaultSettings.xButton = true;

	function completeTour( type ) {
		if ( guiders.currentTour ) {
			var guider = guiders._guiderById(guiders._lastCreatedGuiderID);
			gt.pingServer( guider, guiders.currentTour, type );
		}
		return guiders.endTour(); //remove cookies and hide guider
	}

	/**
	 * onClose(): log hidden event before hiding
	 *
	 * Old version:shows an info guide before closing. Note: the info guide also
	 * generates an event.
	 *
	 * Not onHide() becase that is called even if tour end.
	 */
	guiders.onClose = function ( tourName ) {
		return completeTour( 'hide' );
	};

	// STATS!
	/**
	 * Record stats of guider being shown
	 *
	 * This is a named function so you can override onShow but still record the stat.
	 */
	gt.recordStats = function ( guider ) {
		var tourInfo;

		// hide event.
		// TODO (mattflaschen, 2012-12-17) Is gt-hide reachable?
		if ( guider.id === 'gt-hide' ) {
			if ( guiders.currentTour ) {
				gt.pingServer(guider, guiders.currentTour, 'hide');
			}
			return;
		}

		tourInfo = parseTourId( guider.id );
		if ( tourInfo !== null ) {
			gt.pingServer(guider, tourInfo.name, tourInfo.step);
		}
	};

	gt.pingServer = function ( guider, tour, step ) {
		mw.eventLog.logEvent( 'GuidedTour', {
			eventId: 'guidedtour-' + tour + '-' + step,
			tour: tour,
			step: step,
			lastGuiderId: guider.id
		} );
	};
	guiders._defaultSettings.onShow = gt.recordStats;

	/**
	 * endTour(): When you close the tour (complete) (step=end)
	 */
	gt.endTour = function () {
		return completeTour( 'end' );
	};

	//
	// ONSHOW BINDINGS
	//
	/**
	 * + parseDescription(): Add to onShow to parse description as wikitext
	 */
	gt.parseDescription = function ( guider ) {
		return callApi(guider, 'text');
	};

	/**
	 * + getPageAsDescription(): Add to onshow to make the description as a wikipage reference
	 * to pull content from
	 */
	gt.getPageAsDescription = function ( guider ) {
		return callApi(guider, 'page');
	};

	/**
	 * + callApi(): Called by parseDescription and getPageAsDescription to call the
	 * API and parse wiki text
	 */
	function callApi ( guider, source ) {
		if ( source !== 'page' && source !== 'text' ) {
			mw.log( 'callApi called incorrectly' );
			return;
		}

		// don't parse if already done
		if ( guider.isParsed ) {
			gt.recordStats(guider);
			return;
		}

		var ajaxParams = {
			async: false,
			type: 'POST',
			url: mw.util.wikiScript('api'),
			data: {
				action: 'parse',
				format: 'json'
			}
		};
		ajaxParams.data[source] = guider.description;

		// parse (make synchronous API request)
		var data = JSON.parse(
			$.ajax( ajaxParams ).responseText
		);
		if ( data.error ) {
			if ( source === 'page' ) {
				mw.log('Failed fetching description.' + data.error.info);
			}
			else if ( source === 'text' ) {
				mw.log('Failed parsing description.' + data.error.info);
			}
		}
		else {
			guider.description = data.parse.text['*'],
			guider.isParsed = true;
			// guider html is already "live" so edit it
			guider.elem.find(".guider_description").html(guider.description);

			// we override default onShow
			gt.recordStats(guider);
		}
	};

	/*
	 * shouldSkip bindings
	 *
	 * These are utility mentions useful in constructing a function that can be passed as the shouldSkip parameter to initGuider
	 */

	/**
	 * isPage(): skip if on a particular wiki page
	 */
	gt.isPage = function ( pageName ) {
		return mw.config.get( 'wgPageName' ) === pageName;
	};

	/**
	 * Checks whether the query and pageName match the provided ones.
	 *
	 * It will return true if and only if the actual query string has all of the
	 * mappings from queryParts (the actual query string may be a superset of the
	 * expected), and pageName (optional) is exactly equal to wgPageName.
	 *
	 * If pageName is falsy, the page name will not be considered in any way.
	 *
	 * @param queryParts {Object} Object mapping expected query
	 * parameter names {string} to expected values {string}
	 * @param pageName {string} (optional) pageName
	 *
	 * @return {boolean} true if and only if there is a match per above
	 */
	gt.hasQuery = function ( queryParts, pageName ) {
		if ( pageName && (mw.config.get( 'wgPageName' ) !== pageName) ) {
			return false;
		}

		for ( var qname in queryParts ) {
			if ( mw.util.getParamValue( qname ) !== queryParts[qname] ) {
				return false;
			}
		}
		return true;
	};

	gt.getStep = function () {
		return mw.util.getParamValue( 'step' );
	};

	gt.resumeTour = function ( tourName ) {
		var step = gt.getStep();
		guiders.failStep = stringifyTourId( {
			name: tourName,
			step: 'fail'
		} ); //bind failure step
		if ( (step === 0) && ($.cookie(guiders.cookie)) ) {
			// start from cookie position
			if ( guiders.resume() )
				return;
		}

		if (step === 0) {
			step = 1;
		}
		// start from step specified
		guiders.resume( stringifyTourId( {
			name: tourName,
			step: step
		} ) );
	};
} ( window, document, jQuery, mediaWiki, mediaWiki.libs.guiders ) );
