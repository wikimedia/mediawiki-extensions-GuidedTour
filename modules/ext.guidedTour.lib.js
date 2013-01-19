 /**
  * Part of GuidedTour, the MediaWiki extension for guided tours.
  *
  * Uses Optimize.ly's Guiders library (with WordPress.com customizations).
  *
  * @author     Terry Chay <tchay@wikimedia.org>
  * @author     Matt Flaschen <mflaschen@wikimedia.org>
  * @author     Luke Welling <lwelling@wikimedia.org>
*/

( function ( window, document, $, mw, guiders ) {
	'use strict';

	var gt = mw.guidedTour = mw.guidedTour || {},
		messageParser = new mw.jqueryMsg.parser(),
		cookieName = mw.config.get( 'wgCookiePrefix' ) + '-mw-tour';

	if ( !gt.rootUrl ) {
		gt.rootUrl = mw.config.get( 'wgScript' ) + '?title=MediaWiki:Guidedtour-';
	}

	gt.parseTourId = function ( tourId ) {
		if ( typeof tourId !== 'string' ) {
			return null;
		}
		// Keep in sync with regex in GuidedTourHooks.php
		var TOUR_ID_REGEX = /^gt-([^.-]+)-(\d+)$/;

		var tourMatch = tourId.match( TOUR_ID_REGEX ), tourName, tourStep;
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
			step: tourStep
		};
	};

	gt.stringifyTourId = function ( tourInfo ) {
		if ( typeof tourInfo !== 'object' || tourInfo === null ) {
			return null;
		}

		return 'gt-' + tourInfo.name + '-' + tourInfo.step;
	};

	// XXX (mattflaschen, 2013-01-16):
	// I'm not sure the clean part is necessary, and the url-encoding should be done
	// right before an actual URL is constructed.
	//
	// Right now, it will probably not work correctly if it uses special characters.
	// The URL-encoded version is used too many places.
	/**
	 * Clean out path variables and rawurlencode tour names
	 */
	function cleanTourName( tourName ) {
		return mw.util.rawurlencode( tourName.replace( /^(?:\.\.\/)+/, '' ) );
	}

	/**
	 * Launch a tour.  Tours start themselves, but this allows one tour to launch
	 * another.
	 *
	 * It will first try loading a tour module, then fall back on an on-wiki tour.
	 * This means the caller doesn't need to know how it's implemented (which could
	 * change).
	 *
	 * launchTour is used to load the tour specified in the URL too.  This case does not require
	 * an extra request for an extension-defined tour since it is already loaded.
	 *
	 * @param {string} tourName name of tour
	 * @param {string} tourId id of tour (optional)
	 */
	gt.launchTour = function ( tourName, tourId ) {
		if ( !tourId ) {
			tourId = gt.stringifyTourId( {
				name: tourName,
				step: '1'
			} );
		}

		// Called if we successfully loaded the tour
		function resume () {
			guiders.resume(tourId);
		}

		var tourModuleName = 'ext.guidedTour.tour.' + tourName;
		if ( mw.loader.getState( tourModuleName ) !== null ) {
			mw.loader.using( tourModuleName, resume, function ( err, dependencies ) {
				mw.log( 'Failed to load tour ', tourModuleName,
					'as module. err: ', err, ', dependencies: ',
					dependencies );
			});
		} else {
			mw.log( tourModuleName,
				' is not registered, probably because it is not extension-defined.' );

			// append to request raw JS code without page markup
			var rawJS = '&action=raw&ctype=text/javascript';
			var onWikiTourUrl = gt.rootUrl + 'tour-' + tourName + '.js' + rawJS;
			mw.log( 'Attempting to load on-wiki tour from ', onWikiTourUrl );

			$.getScript( onWikiTourUrl )
			.done( function ( script, textStatus ) {
				// missing raw requests give 0 length document and 200 status not 404
				if ( script.length === 0 ) {
					mw.log( 'Tour ' + tourName + ' is empty. Does the page exist?' );
				}
				else {
					resume();
				}
			})
			.fail( function ( jqxhr, settings, exception ) {
				mw.log( 'Failed to load tour ' + tourName );
			});
		}
	};

	// cookie the users when they are in the tour
	guiders.cookie = cookieName;
	guiders.cookieParams = { path: '/' };

	// add x button to top right
	guiders._defaultSettings.xButton = true;

	guiders._defaultSettings.closeOnEscape = true;
	guiders._defaultSettings.closeOnClickOutside = true;

	/**
	 * Attempts to automatically launch a tour based on the environment
	 *
	 * If the query string has a tour parameter, it attempts to use that.
	 * Otherwise, it tries to use the cookie.
	 *
	 * If both fail, it does nothing.
	 */
	gt.launchTourFromEnvironment = function () {
		// Tour is either in the query string or cookie (prefer query string)
		var tourName = mw.util.getParamValue( 'tour' );
		var tourId, tourInfo;
		//clean out path variables
		if ( tourName ) {
			tourName = cleanTourName( tourName );
		}
		if ( tourName !== null && tourName.length !== 0 ) {
			var step = mw.util.getParamValue( 'step' );
			if ( step === null || step === '' ) {
				step = '1';
			}
			tourId = gt.stringifyTourId( {
				name: tourName,
				step: step
			} );
		} else {
			tourId = $.cookie( cookieName );
			tourInfo = gt.parseTourId( tourId );
			if ( tourInfo !== null ) {
				tourName = tourInfo.name;
			}
		}
		if ( tourId && tourName ) {
			gt.launchTour( tourName, tourId );
		}
	};

	/**
	 * Logs a dismissal event, either 'hide' for temporary dismissal or 'end' if the
	 * user ended the tour.
	 *
	 * @param {string} type type of dismissal, 'hide' or 'end'
	 */
	function logDismissal( type ) {
		if ( gt.currentTour ) {
			var guider = guiders._guiderById(guiders._lastCreatedGuiderID);
			gt.pingServer( guider, gt.currentTour, type );
		}
	}

	/**
	 * Provides onClose handler called by Guiders on a user-initiated close action.
	 *
	 * Determines whether to hide or end tour (the latter removes cookie).
	 *
	 * Logs event accordingly.
	 *
	 * Distinct from guider.onHide() becase that is called even if the tour ends.
	 *
	 * @param {Object} guider guider object
	 * @param {boolean} isAlternativeClose false for text Close button (which should not occur for us), true for anything else
	 *
	 * @return {boolean} true to end tour, false to dismiss
	 */
	function handleOnClose(guider, isAlternativeClose) {
		var $guiderElem = guider.elem, $checkbox, shouldEndTour, dismissalType;
		$checkbox = $guiderElem.find( '.guidedtour-end-tour-checkbox-label input' );
		if ( $checkbox.is( ':checked' ) ) {
			shouldEndTour = true;
			dismissalType = 'end';
		} else {
			shouldEndTour = false;
			dismissalType = 'hide';
		}

		logDismissal( dismissalType );
		return shouldEndTour;
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
			if ( gt.currentTour ) {
				gt.pingServer(guider, gt.currentTour, 'hide');
			}
			return;
		}

		tourInfo = gt.parseTourId( guider.id );
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
	 * Ends the tour, then logs, passing a step of 'end'
	 */
	gt.endTour = function () {
		logDismissal( 'end' );
		guiders.endTour();
	};

	/**
	 * Hides the guider(s), then logs, passing a step of 'hide'
	 */
	gt.hideAll = function () {
		logDismissal( 'hide' );
		guiders.hideAll();
	};

	// onShow bindings

	/**
	 * Parses description as wikitext
	 *
	 * Add this to onShow.
	 *
	 * @param guider Guider object to set description on
	 */
	gt.parseDescription = function ( guider ) {
		callApi( guider, 'text' );
	};

	/**
	 * Parses a wiki page and uses the HTML as the description.
	 *
	 * To use this, put the page name as the description, and use this as the value of onShow.
	 *
	 * @param guider Guider object to set description on
	 */
	gt.getPageAsDescription = function ( guider ) {
		callApi( guider, 'page' );
	};

	/*
	 * TODO (mattflaschen, 2012-12-29): Find a way to remove or improve this.
	 * Synchronous requests are generally considered bad, and even an async request
	 * for each guider wouldn't be ideal.
	 *
	 * If we can get everything we need from jqueryMsg, we can deprecate this for
	 * extension-defined tours.
	 */
	/**
	 * Calls the MediaWiki API to parse wiki text.
	 *
	 * Called by parseDescription and getPageAsDescription.
	 *
	 * @param guider Guider object to set description on
	 * @param source source of wikitext, either 'page' for a wiki page name, or
	 * 'text' for wikitext.  In either case, the value goes in the description
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
			url: mw.util.wikiScript( 'api' ),
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
				mw.log( 'Failed fetching description.' + data.error.info );
			}
			else if ( source === 'text' ) {
				mw.log( 'Failed parsing description.' + data.error.info );
			}
		}
		else {
			guider.description = data.parse.text['*'],
			guider.isParsed = true;
			// guider html is already "live" so edit it
			guider.elem.find( '.guider_description' ).html( guider.description );

			gt.recordStats( guider );
		}
	}

	/*
	 * shouldSkip bindings
	 *
	 * These are utility functions useful in constructing a function that can be passed
	 * as the shouldSkip parameter to gt.initGuider.
	 */

	/**
	 * Checks whether user is on a particular wiki page.
	 *
	 * @param pageName expected page name
	 *
	 * @return true if the page name is a strict match, false otherwise
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
	// End shouldSkip bindings

	/**
	 * Checks whether they just saved an edit.  Currently this uses Extension:PostEdit
	 *
	 * @return true if they just saved an edit, false otherwise
	 */
	gt.isPostEdit = function () {
		return mw.config.get( 'wgPostEdit' );
	};

	gt.getStep = function () {
		return mw.util.getParamValue( 'step' );
	};

	gt.resumeTour = function ( tourName ) {
		var step = gt.getStep();
		// Bind failure step (in case there are problems).
		guiders.failStep = gt.stringifyTourId( {
			name: tourName,
			step: 'fail'
		} );
		if ( (step === 0) && $.cookie( guiders.cookie ) ) {
			// start from cookie position
			if ( guiders.resume() )
				return;
		}

		if (step === 0) {
			step = 1;
		}
		// start from step specified
		guiders.resume( gt.stringifyTourId( {
			name: tourName,
			step: step
		} ) );
	};

	/**
	 * Converts a message key to a parsed HTML message using jqueryMsg.
	 *
	 * @param {string} key message key
	 * @return {string} HTML of parsed message
	 */
	function getMessage( key ) {
		return messageParser.parse( key ).html();
	}

	/**
	 * Gets a labelled checkbox for ending the tour
	 *
	 * @return {string} HTML of end tour checkbox and label
	 */
	function getEndTourCheckbox() {
		var labelContents, checkboxHtml;
		checkboxHtml = mw.html.element( 'input', {
			type: 'checkbox'
		} );
		labelContents =	checkboxHtml + mw.msg( 'guidedtour-end-tour' );
		return mw.html.element( 'label', {
			'class': 'guidedtour-end-tour-checkbox-label'
		}, new mw.html.Raw( labelContents ) );
	}

	/**
	* Handles the okay button when it depends on the end tour checkbox.
	*
	* Ends tour (logging it) if box is checked.  Otherwise, it calls okayFunction.
	*
	* @param {HTMLElement} btn okay button
	* @param {Function} okayFunction function to execute if they did not check the
	* end tour box.  Passes a single parameter, the raw DOM element of the button.
	*/
	function doConditionalOkayAction( btn, okayFunction ) {
		var $guiderElem, $checkbox;
		$guiderElem = $( btn ).closest( '.guider' );
		// If there is no checkbox, it will take the unchecked path.
		$checkbox = $guiderElem.find( '.guidedtour-end-tour-checkbox-label input' );
		if ( $checkbox.is( ':checked' ) ) {
			gt.endTour();
		} else {
			okayFunction( btn );
		}
	}

	/**
	 * Gets an okay button as passed to guiders
	 *
	 * @param {Function} okayFunction function to call if they did not end the tour.
	 * Passes a single parameter, the raw DOM element of the button.
	 */
	function getOkayButton(	okayFunction ) {
		return {
			name: getMessage ( 'guidedtour-okay-button' ),
			onclick: function () {
				okayFunction( this );
			},
			html: {
				'class': 'guider_button guidedtour-okay-button'
			}
		};
	}

	/**
	 * Gets an okay button as passed to guiders.  Automatically adds conditional logic
	 * based on end tour checkbox.
	 *
	 * @param {Function} conditionalFunction function to call if they did not check the box.
	 * Passes a single parameter, the raw DOM element of the button.
	 */
	function getConditionalOkayButton( conditionalFunction ) {
		return getOkayButton ( function ( btn ) {
			doConditionalOkayAction( btn, conditionalFunction );
		} );
	}

	/**
	 * Converts a tour's button specification to a button that we
	 * pass to Guiders.
	 *
	 * This has special handling for okay, which is always present last.  See initGuider.
	 *
	 * Handles actions and i18n.
	 *
	 * @param {Array} buttonSpecs button specifications as used in tour, or falsy, which
	 * is equivalent to an empty array.
	 * @return {Array} array of buttons as Guiders expects
	 */
	function getButtons( buttonSpecs ) {
		var okayButton, guiderButtons, spec, currentButton;
		buttonSpecs = buttonSpecs || [];
		guiderButtons = [];
		for ( var i = 0; i < buttonSpecs.length; i++ ) {
			spec = buttonSpecs[i];
			if ( spec.action !== undefined ) {
				switch ( spec.action ) {
					case 'next':
						okayButton = getConditionalOkayButton( function() {
							guiders.next();
						} );
						break;
					case 'end':
						okayButton = getOkayButton( function () {
							gt.endTour();
						} );
						break;
					default:
						throw new Error( spec.action + 'is not a supported button action.' );

				}

			} else {
				currentButton = $.extend( true, {}, spec );
				if ( currentButton.namemsg ) {
					currentButton.name = getMessage( spec.namemsg );
					delete currentButton.namemsg;
				}
				guiderButtons.push( currentButton );
			}
		}

		// Ensure there is always an okay button.  In some cases, there will not be
		// a next, since the user is prompted to do something else
		// (e.g. click 'Edit')
		if ( okayButton === undefined ) {
			okayButton = getConditionalOkayButton( function () {
				gt.hideAll();
			} );
		}
		guiderButtons.push( okayButton );

		return guiderButtons;
	}

	/**
	 * Initializes a guider by calling guiders.initGuider
	 *
	 * This uses the proper message calls when you add msg to the end of the
	 * field name.
	 *
	 * This applies to titlemsg, descriptionmsg, and namemsg (for each button object
	 * in the buttons field (which is an array))
	 *
	 * For example:
	 *
	 * descriptionmsg: 'guidedtour-tour-currenttourname-message-name' )
	 *
	 * results in:
	 *
	 * description:
	 * messageParser.parse( 'guidedtour-tour-currenttourname-message-name' )
	 *
	 * where messageParser is an instance of mw.jqueryMsg.parser.
	 *
	 * It also automatically includes a checkbox and Okay button.  If you don't want to
	 * show the checkbox, pass:
	 *
	 * showEndTour: false
	 *
	 * You can pass a defined action as part of the buttons array.  The only
	 * one currently supported is:
	 *
	 * { action: 'next' }
	 *
	 * which goes to the next step.
	 *
	 * If the user clicks Okay:
	 *
	 * * If the checkbox is checked, the tour will end.
	 * * Otherwise, if you passed in a action (see above), it will occur.
	 * * Otherwise, it will close the current step.
	 *
	 * @param {object} options options object matching the guiders one, except for
	 * modifications noted above.
	 *
	 */
	gt.initGuider = function( options ) {
		var oldOnClose;
		options = $.extend( true, {
			onClose: $.noop,
			showEndTour: true
		}, options );

		oldOnClose = options.onClose;
		options.onClose = function() {
			oldOnClose.apply ( this, arguments );
			return handleOnClose.apply( this, arguments );
		};

		if ( options.titlemsg ) {
			options.title = getMessage( options.titlemsg );
			delete options.titlemsg;
		}

		if ( options.descriptionmsg ) {
			options.description = getMessage( options.descriptionmsg );
			delete options.descriptionmsg;
		}

		options.buttons = getButtons( options.buttons );

		if ( options.showEndTour ) {
			options.buttonCustomHTML = getEndTourCheckbox();
		}
		guiders.initGuider( options );
	};
} ( window, document, jQuery, mediaWiki, mediaWiki.libs.guiders ) );
