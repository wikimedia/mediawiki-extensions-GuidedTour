 /**
  * Extension for Guided Tour for MediaWiki
  *
  * Based on a WordPress.com customized version of Optimize.ly's Guiders.js file.
  *
  * To use create a tour in /modules/tour then load a page with tour=TourName appended to the url
  * To see if it works index.php?tour=test is a start
  *
  * @author     terry chay <tchay@wikimedia.org>
  * @author     Luke Welling <lwelling@wikimedia.org>
  * @version    $Id$
*/
//The external library guiders.js relies on a global
window.guiders = guiders;

( function ( window, document, jQuery, mw ) {
	'use strict';
	var gt = mw.guidedTour = mw.guidedTour || {};

	if (!gt.tourUrl) {
		gt.tourUrl   = mw.config.get('wgScript')+'?title=MediaWiki:GuidedTour/';
	}

	/**
	 * clean out path variables and the like in tour names
	 */
	gt.cleanTourName = function(tourName) {
		return mw.util.rawurlencode( tourName.replace(/^(?:\.\.\/)+/, '') );
	};

	// tour is either in get string or cookie (prefer get string)
	var tourName = mw.util.getParamValue( 'tour' );
	var tourId;
	//clean out path variables
	if (tourName) { tourName = gt.cleanTourName( tourName ); }
	if (tourName) {
		var step = mw.util.getParamValue( 'step' );
		if (!step) { step = '1'; }
		tourId = 'gt-'+tourName+'-'+step;
	} else {
		tourId = $.cookie('mw-tour');
		if (tourId) {
			var guiderid = tourId.substr(3); //strip off 'gt-'
			var pieces = guiderid.split(/-/);
			// should always happen, but let's be careful
			if ( pieces.length != 1 ) {
				tourName = guiderid.substr(0, guiderid.length - pieces[pieces.length-1].length - 1);
				tourName = gt.cleanTourName( tourName );
			}
		}
	}
	// Don't bother loading any more code if there isn't a tour going on
	if ( !tourId || !tourName ) { return; }

	/**
	 * mw.guidedTour.launchTour(): Load a tour javascript and launch a tour
	 */
	gt.launchTour = function(tourName, tourId) {
		if ( !tourId ) {
			tourId = 'gt-'+tourName+'-1';
		}
		// append to request raw JS code without page markup
		var rawJS = '&action=raw&ctype=text/javascript';
		$.getScript( gt.tourUrl + tourName + '.js' + rawJS )
		.done( function(script, textStatus ) {
			// missing raw requests give 0 length document and 200 status not 404
			if( script.length<1 ) {
				mw.log( 'Tour ' + tourName + ' is empty. Does the page exist?' );
			}
			else {
				// if we successfully loaded the tour
				guiders.resume(tourId);
			}
		})
		.fail( function( jqxhr, settings, exception ) {
			mw.log( 'Failed to load tour ' + tourName );
		});
	};

	// load custom CSS from wiki page MediaWiki:GuidedTour/custom.css
        var cssUrl = mw.config.get('wgServer') +
		mw.config.get('wgScript') +
		'?title=MediaWiki:GuidedTour/custom.css&action=raw&ctype=text/css';
	mw.loader.load(cssUrl, 'text/css');

	// launch the tour.
	mw.loader.using('GuidedTour', function() { gt.launchTour(tourName, tourId); });

	// List of tours currently loaded
	if (!gt.installed) { gt.installed = {}; }


	// cookie the users when they are in the tour
	guiders.cookie = 'mw-tour';
	guiders.cookieParams = { path: '/' };
	// add x button to top right
	guiders._defaultSettings.xButton = true;

	// good for tracking what tour we are on
	guiders.currentTour = '';

	/**
	 * onClose(): log hidden event before hiding
	 *
	 * Old version:shows an info guide before closing. Note: the info guide also
	 * generates an event.
	 *
	 * Not onHide() becase that is called even if tour end.
	 */
	guiders.onClose = function (tourName) {
		// interstial hiding...
		//guiders.hideAll(); //Hide current guider
		//guiders.show('gt-hide'); //show future help notice
		// TODO: should launch a default tour element

		// notify that we are dismissing the tour
		if ( guiders.currentTour ) {
			var guider = guiders._guiderById(guiders._lastCreatedGuiderID);
			gt.pingServer( guider, guiders.currentTour, 'hide' );
		}
		guiders.endTour(); //remove cookies and hide guider
	};

	// STATS!
	/**
	 * Record stats of guider being shown
	 *
	 * This is a named function so you can override onShow but still record the stat.
	 */
	gt.recordStats = function(guider) {
		//strip gt-
		var guiderid = guider.id.substr(3);

		// hide event
		if ( guiderid == 'gt-hide' ) {
			if ( guiders.currentTour ) {
				gt.pingServer(guider, guiders.currentTour, 'hide');
			}
			return;
		}

		var pieces = guiderid.split(/-/);

		if ( pieces.length == 1 ) { return; } // should never happen, but let's be careful
		var tourname = guiderid.substr(0, guiderid.length - pieces[pieces.length-1].length - 1);
		gt.pingServer(guider, tourname, pieces[pieces.length-1]);
	};

	gt.pingServer = function(guider, tour,step) {
		var eventObj = {
			event_id: 'guidedtour-'+tour+'-'+step,
			tour: tour,
			step: step,
			last_id: guider.id
		};
		if ( mw.e3 && mw.e3.track ) {
			mw.e3.track( eventObj );
		}
	};
	guiders._defaultSettings.onShow = gt.recordStats;

	/**
	 * endTour(): When you close the tour (complete) (step=end)
	 */
	gt.endTour = function() {
		if ( guiders.currentTour ) {
			var guider = guiders._guiderById(guiders._lastCreatedGuiderID);
			gt.pingServer( guider, guiders.currentTour, 'end' );
		}
		guiders.endTour(); //remove session cookie and hide tour
	};


	//
	// ONSHOW BINDINGS
	//
	/**
	 * + parseDescription(): Add to onShow to parse description as wikitext
	 */
	gt.parseDescription = function(guider) {
		return gt.callApi(guider, 'text');
	};

	/**
	 * + getPageAsDescription(): Add to onshow to make the description as a wikipage reference
	 * to pull content from
	 */
	gt.getPageAsDescription = function(guider) {
		return gt.callApi(guider, 'page');
	};
	
	/**
	 * + callApi(): Called by parseDescription and getPageAsDescription to call the
	 * API and parse wiki text
	 */
	gt.callApi = function(guider, source) {
		if ('page' != source && 'text' != source) {
			mw.log( 'callApi called incorrectly' );
			return;
		}

		// don't parse if already done
		if (guider.isParsed) { gt.recordStats(guider); return; }

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
		if( data.error ) {
			if ( 'page' == source ) {
				mw.log('Failed fetching description.' + data.error.info);
			}
			else if ( 'text' == source ) {
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

	//
	// SHOULDSKIP BINDINGS
	//
	/**
	 * isPage(): skip if on a particular wiki page
	 */
	gt.isPage = function(pageName) {
		return function() {
			return ( mw.config.get( 'wgPageName' ) == pageName );
		};
	};

	/**
	 * hasQuery(): skip if has query string (object) and path
	 */
	gt.hasQuery = function (queryParts, pageName) {
		if ( pageName && (mw.config.get( 'wgPageName' ) == pageName) ) { return function() { return false; }; }

		// TODO: could use mw.util.getParamValue( qname ) here?
		var urlParams = gt.getQuery();
		for (var qname in queryParts) {
			if ( typeof(urlParams[qname]) == 'undefined' )  { return false;  }
			if ( queryParts[qname] && ( urlParams[qname] != queryParts[qname] ) ) {  return false; }
		}
		//return function() { return true; };
		return true;
	};

	/**
	 * Bind this to onshow for submenus elements in the admin menu
	 *
	 * To use this for a submenu guider
	 *
	 * 1. onShow should be this
	 * 2. prev should be set to the the guide to backtrack to
	 */
	gt.onShowCheckSubmenuShown = function(guider) {
		// shouldn't really need this first line.
		var attachObj = ( typeof(guider.attachTo)=='string' ) ? $(guider.attachTo) : guider.attachTo;

		if ( attachObj.is(':hidden') ) {
			return guiders.show(guider.prev);
		}

		// default behavior
		gt.recordStats(guider);
	};


	gt.forceExpandMenu = function( menuItem ) {
		var submenu = $( menuItem + ' .wp-submenu');
		if ( !submenu.is(':visible') ) {
			menuItem.toggle( submenu );
		}
	};

	gt.isSubmenuVisible = function( menuItem ) {
		return $( menuItem + ' .wp-submenu').is(':visible');
	};

	gt.getStep = function() {
		var qs = document.location.search;
		var hasStep = qs.indexOf('step=');
		return (hasStep > 0)? parseInt( qs.substring( hasStep+5, hasStep + 7 ), 10 ) : 0;
	};

	gt.resumeTour = function (tourName) {
		var step = gt.getStep();
		guiders.failStep = 'gt-' + tourName + '-fail'; //bind failure step
		if ( (step === 0) && ($.cookie(guiders.cookie)) ) {
			// start from cookie position
			if ( guiders.resume() )
				return;
		}

		if (step === 0) step = 1;
		// start from step specified
		guiders.resume('gt-' + tourName + '-' + step);
	};

} ( window, document, jQuery, mw, guiders ) );
