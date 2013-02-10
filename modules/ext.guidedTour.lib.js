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
		MW_NS_TOUR_PREFIX = 'MediaWiki:Guidedtour-tour-',
		messageParser = new mw.jqueryMsg.parser(),
		userId = mw.config.get( 'wgUserId' ),
		currentTourState;

	/**
	 * Error subclass for errors that occur during tour definition
	 *
	 * @constructor
	 * @extends Error
	 **/
	gt.TourDefinitionError = function ( message ) {
		this.message = message;
	};

	gt.TourDefinitionError.prototype = new Error();
	gt.TourDefinitionError.prototype.constructor = gt.TourDefinitionError;

	// Setup default values for logging, unless they're logged out.  This doesn't mean
	// we'll necessarily actually log.
	function setupLogging() {
		if ( userId !== null ) {
			// Don't log anons
			mw.eventLog.setDefaults( 'GuidedTour', {
				userId: userId
			} );
		}
	}

	// If logging is enabled, log.
	function pingServer( action, guiderId ) {
		var tourInfo, tourName, tourStep;

		if ( currentTourState.shouldLog && userId !== null ) {
			tourInfo = gt.parseTourId( guiderId );
			tourName = tourInfo.name;
			tourStep = Number( tourInfo.step );

			mw.eventLog.logEvent( 'GuidedTour', {
				tourName: tourName,
				action: action,
				step: tourStep
			} );

			if ( action === 'impression' ) {
				if ( currentTourState.stepCount === tourStep ) {
					mw.eventLog.logEvent( 'GuidedTour', {
						tourName: tourName,
						action: 'complete',
						step: tourStep
					} );
				}
			}
		}
	}

	/**
	 * Parses tour ID into an object with name and step keys.
	 *
	 * @param {string} tourId ID of tour
	 *
	 * @return {Object} object with name (string) and step (string),
	 * or null if invalid input
	 */
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

	/**
	 * Serializes tour information into a string
	 *
	 * @param {Object} tourInfo object with name (string) and step (number or string)
	 *
	 * @return {string} ID of tour, or null if invalid input
	 */
	gt.makeTourId = function ( tourInfo ) {
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
		var tourModuleName, onWikiTourUrl;

		if ( !tourId ) {
			tourId = gt.makeTourId( {
				name: tourName,
				step: '1'
			} );
		}

		// Called if we successfully loaded the tour
		function resume() {
			guiders.resume(tourId);
		}

		tourModuleName = 'ext.guidedTour.tour.' + tourName;
		if ( mw.loader.getState( tourModuleName ) !== null ) {
			mw.loader.using( tourModuleName, resume, function ( err, dependencies ) {
				mw.log( 'Failed to load tour ', tourModuleName,
					'as module. err: ', err, ', dependencies: ',
					dependencies );
			});
		} else {
			mw.log( tourModuleName,
				' is not registered, probably because it is not extension-defined.' );

			onWikiTourUrl = mw.config.get( 'wgScript' ) + '?' + $.param( {
				title: MW_NS_TOUR_PREFIX + tourName + '.js',
				action: 'raw',
				ctype: 'text/javascript'
			} );
			mw.log( 'Attempting to load on-wiki tour from ', onWikiTourUrl );

			$.getScript( onWikiTourUrl )
			.done( function ( script ) {
				// missing raw requests give 0 length document and 200 status not 404
				if ( script.length === 0 ) {
					mw.log( 'Tour ' + tourName + ' is empty. Does the page exist?' );
				}
				else {
					resume();
				}
			})
			.fail( function () {
				mw.log( 'Failed to load tour ' + tourName );
			});
		}
	};

	// cookie the users when they are in the tour
	guiders.cookie = mw.config.get( 'wgCookiePrefix' ) + '-mw-tour';
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
			tourId = gt.makeTourId( {
				name: tourName,
				step: step
			} );
		} else {
			tourId = $.cookie( guiders.cookie );
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
	 * Sets the tour cookie, given a tour name and optional step.
	 *
	 * You can use this when you want the tour to be displayed on a future page.
	 *
	 * @param {string} name tour name
	 * @param {number|string} (optional) step tour step (defaults to 1)
	 */
	gt.setTourCookie = function (name, step) {
		var id;
		step = step || 1;
		id = gt.makeTourId( {
			name: name,
			step: step
		} );
		$.cookie( guiders.cookie, id, guiders.cookieParams );
	};

	/**
	 * Logs a dismissal event.
	 */
	function logDismissal() {
		if ( currentTourState ) {
			pingServer( 'hide', guiders._lastCreatedGuiderID );
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
	 *
	 * @return {boolean} true to end tour, false to dismiss
	 */
	function handleOnClose( guider ) {
		var $guiderElem = guider.elem, $checkbox, shouldEndTour;
		$checkbox = $guiderElem.find( '.guidedtour-end-tour-checkbox-label input' );
		if ( $checkbox.is( ':checked' ) ) {
			shouldEndTour = true;
		} else {
			shouldEndTour = false;
		}

		logDismissal();
		return shouldEndTour;
	}

	// STATS!
	/**
	 * Record stats of guider being shown
	 *
	 * This is a named function so you can override onShow but still record the stat.
	 */
	gt.recordStats = function ( guider ) {
		var tourInfo;

		tourInfo = gt.parseTourId( guider.id );
		if ( tourInfo !== null ) {
			pingServer( 'impression', guider.id );
		}
	};

	guiders._defaultSettings.onShow = gt.recordStats;

	/**
	 * Ends the tour, then logs, passing a step of 'end'
	 */
	gt.endTour = function () {
		logDismissal();
		guiders.endTour();
	};

	/**
	 * Hides the guider(s), then logs, passing a step of 'hide'
	 */
	gt.hideAll = function () {
		logDismissal();
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
			guider.description = data.parse.text['*'];
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
	 * as the shouldSkip parameter to a step.
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
		guiders.failStep = gt.makeTourId( {
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
		guiders.resume( gt.makeTourId( {
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
	 * This has special handling for okay, which is always present last.  See
	 * gt.defineTour.
	 *
	 * Handles actions and i18n.
	 *
	 * @param {Array} buttonSpecs button specifications as used in tour, or falsy, which
	 * is equivalent to an empty array.  Will be mutated.
	 * @return {Array} array of buttons as Guiders expects
	 */
	function getButtons( buttonSpecs ) {
		var okayButton, guiderButtons, currentButton;

		function next() {
			guiders.next();
		}

		function endTour() {
			gt.endTour();
		}

		buttonSpecs = buttonSpecs || [];
		guiderButtons = [];
		for ( var i = 0; i < buttonSpecs.length; i++ ) {
			currentButton = buttonSpecs[i];
			if ( currentButton.action !== undefined ) {
				switch ( currentButton.action ) {
					case 'next':
						okayButton = getConditionalOkayButton( next );
						break;
					case 'end':
						okayButton = getOkayButton( endTour );
						break;
					default:
						throw new gt.TourDefinitionError( '\'' + currentButton.action + '\'' + ' is not a supported button action.' );
				}

			} else {
				if ( currentButton.namemsg ) {
					currentButton.name = getMessage( currentButton.namemsg );
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
	 * Clones guider options and augments with two fields, onClose and showEndTour
	 *
	 * @param {Object} options guider options object
	 *
	 * @return {Object} augmented guider
	 */
	function augmentGuider( options ) {
		return $.extend( true, {
			onClose: $.noop,
			showEndTour: true
		}, options );
	}

	/**
	 * Internal function used for initializing a guider.  Other methods call this after all augmentation is complete.
	 *
	 * @param {Object} options augmented guider options object
	 *
	 * @return {boolean} true, on success; throws otherwise
	 */
	function initializeGuiderInternal( options ) {
		var oldOnClose = options.onClose;
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

		return true;
	}

	/**
	 * Creates a tour based on an object specifying it, but does not show
	 * it immediately
	 *
	 * If input is invalid, it will throw mw.guidedTour.TourDefinitionError.
	 *
	 * @param {Object} tourSpec specification of tour, with the following required keys:
	 *
	 * name: Name of tour
	 * steps: Array of steps, each of which takes the same keys as guiders.initGuider
	 * with the following additions and modifications:
	 *
	 * titlemsg - Like title, but treats the value as a message key
	 * descriptionmsg - Like description, but treats the value as a message key
	 *
	 * For the 'buttons' array in each step, each button can have:
	 *
	 * namemsg - Like name (text of button), but treats the values a message key
	 *
	 * Each step also automatically includes a checkbox and Okay button.  If you don't want to
	 * show the checkbox, pass:
	 *
	 * showEndTour: false
	 *
	 * as a step key.
	 *
	 * You can pass a defined action as part of the buttons array.  The only
	 * actions currently supported are:
	 *
	 * next - Goes to the next step.
	 * end - Ends the tour.
	 *
	 * In this case, the element of the buttons array looks like:
	 *
	 * {
	 *	action: 'next'
	 * }
	 *
	 * If the user clicks Okay:
	 *
	 * * If the checkbox is checked, the tour will end.
	 * * Otherwise, if you passed in a action (see above), it will occur.
	 * * Otherwise, it will close the current step.
	 *
	 * If input is invalid, it will throw mw.guidedTour.TourDefinitionError.
	 *
	 * @param {Object} options options object matching the guiders one, except for
	 * modifications noted above.
	 *
	 * @return {boolean} true, on success; throws otherwise
	 *
	 *
	 * Optional keys are:
	 *
	 * shouldLog: Whether to log events to EventLogging.  Defaults to false.
	 *
	 * @return {boolean} true, on success; throws otherwise
	 */
	gt.defineTour = function( tourSpec ) {
		var steps, stepInd = 0, stepCount, step, id;

		if ( !$.isPlainObject( tourSpec ) ) {
			throw new gt.TourDefinitionError( 'There must be a single argument, \'tourSpec\', which must be an object.' );
		}

		if ( $.type( tourSpec.name ) !== 'string' ) {
			throw new gt.TourDefinitionError( '\'tourSpec.name\' must be a string, the tour name.' );
		}

		steps = tourSpec.steps;
		if ( !$.isArray( steps ) ) {
			throw new gt.TourDefinitionError( '\'tourSpec.steps\' must be an array, the list of steps.' );
		}

		stepCount = steps.length;
		for ( stepInd = 1; stepInd <= stepCount; stepInd++ ) {
			step = augmentGuider( steps[stepInd - 1] );

			id = gt.makeTourId( {
				name: tourSpec.name,
				step: stepInd
			} );
			step.id = id;

			if ( stepInd !== stepCount ) {
				step.next = gt.makeTourId( {
					name: tourSpec.name,
					step: stepInd + 1
				} );
			}

			initializeGuiderInternal( step );
		}

		// Set the current tour name after all the guiders initialize successfully
		currentTourState = {
			name: tourSpec.name,
			shouldLog: tourSpec.shouldLog || false,
			stepCount: stepCount
		};

		return true;
	};

	/**
	 * Initializes a guider
	 *
	 * This is deprecated.  It will be removed, so you should use gt.defineTour instead.
	 *
	 * The parameter is the same as a step of gt.defineTour, except that gt.initGuider also requires an id and next
	 * as part of the object.
	 *
	 * If using this API, you must also put:
	 *
	 * gt.currentTour = 'test';
	 *
	 * at the top of your file.
	 *
	 * @deprecated
	 *
	 * @param {Object} options options object matching the gt.defineTour step, except as noted above
	 *
	 * @return {boolean} true, on success; throws otherwise
	 */
	gt.initGuider = function( options ) {
		var tourInfo;

		// Validate id and gt.currentTour, since these could cause confusion if someone copies from a gt.defineTour call to a gt.initGuider one.
		if ( $.type( options.id ) !== 'string' ) {
			throw new gt.TourDefinitionError( '\'options.id\' must be a string, in the form gt-tourname-stepnumber.' );
		}

		if ( $.type( gt.currentTour ) !== 'string' ) {
			throw new gt.TourDefinitionError( '\'gt.currentTour\' must be a string, the tour name.' );
		}

		// Do this every time.  We don't have any way of knowing how many times
		// they'll call gt.initGuider.
		tourInfo = gt.parseTourId( options.id );
		currentTourState = {
			name: gt.currentTour,
			shouldLog: false,
			stepCount: Number( tourInfo.step )
		};

		return initializeGuiderInternal( augmentGuider( options ) );
	};

	/**
	 * Listen for events that could potentially be logged (depending on shouldLog)
	 */
	function setupGuiderListeners() {
		$( document.body ).on( 'click', '.guider a[href]', function () {
			var action = $( this ).is( '.guider_button' ) ? 'button-click' : 'link-click';
			pingServer( action, $( this ).parents( '.guider ').attr( 'id' ) );
		} );
	}

	/**
	 * Guiders has a window resize and document ready listener.
	 *
	 * However, we're adding some MW-specific code. Currently, this listens for a
	 * custom event from the WikiEditor extension, which fires after the extension's
	 * async loop finishes. If WikiEditor is not running this event just won't fire.
	 */
	function setupRepositionListeners() {
		$( '#wpTextbox1' ).on( 'wikiEditor-toolbar-doneInitialSections', function () {
			guiders.reposition();
		} );
	}

	setupLogging();

	$( document ).ready( function () {
		setupRepositionListeners();
		setupGuiderListeners();
	} );
} ( window, document, jQuery, mediaWiki, mediaWiki.libs.guiders ) );
