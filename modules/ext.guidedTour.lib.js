/**
 * GuidedTour public API
 *
 * Set as mw.guidedTour and often aliased to gt locally
 *
 * Maintainer:
 *
 * @author Matt Flaschen <mflaschen@wikimedia.org>
 *
 * Contributors:
 *
 * @author Terry Chay <tchay@wikimedia.org>
 * @author Ori Livneh <olivneh@wikimedia.org>
 * @author S Page <spage@wikimedia.org>
 * @author Luke Welling <lwelling@wikimedia.org>
 *
 * @class mw.guidedTour
 * @singleton
 */
 /*
  * Part of GuidedTour, the MediaWiki extension for guided tours.
  *
  * Uses Optimize.ly's Guiders library (with customizations developed at WordPress
  * and MediaWiki).
  */
( function ( window, document, $, mw, guiders ) {
	'use strict';

	var gt,
		cookieName, cookieParams,
		skin = mw.config.get( 'skin' ),
		messageParser = new mw.jqueryMsg.parser(),
		// Non-null if user is logged in.
		userId = mw.config.get( 'wgUserId' ),
		currentTourState;

	/**
	 * Setup default values for logging, unless they're logged out.  This doesn't mean
	 * we'll necessarily actually log.
	 *
	 * @private
	 *
	 * @return {void}
	 */
	function setupLogging() {
		if ( userId !== null ) {
			// Don't log anons
			mw.eventLog.setDefaults( 'GuidedTour', {
				userId: userId
			} );
		}
	}

	/**
	 * If logging is enabled, log.
	 *
	 * See https://meta.wikimedia.org/wiki/Schema:GuidedTour for more information.
	 *
	 * @private
	 *
	 * @param {string} action Schema action to log
	 * @param {string} guiderId ID of relevant guider
	 *
	 * @return {void}
	 */
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
	 * Record stats of guider being shown, if logging is enabled
	 *
	 * @private
	 *
	 * @param {Object} guider Guider object to record
	 *
	 * @return {void}
	 */
	function recordStats ( guider ) {
		var tourInfo;

		tourInfo = gt.parseTourId( guider.id );
		if ( tourInfo !== null ) {
			pingServer( 'impression', guider.id );
		}
	}

	/**
	 * Handles the onShow call by guiders.  May saves to cookie and log, depending
	 * on settings.
	 *
	 * @private
	 *
	 * @param {Object} guider Guider object provided by Guiders.js
	 *
	 * @return {void}
	 */
	function handleOnShow ( guider ) {
		//If necessary, save the guider id to a cookie
		if ( guider.changeCookie ) {
			$.cookie( cookieName, guider.id, cookieParams );
		}

		recordStats( guider );
	}

	// XXX (mattflaschen, 2013-01-16):
	// I'm not sure the clean part is necessary, and the url-encoding should be done
	// right before an actual URL is constructed.
	//
	// Right now, it will probably not work correctly if it uses special characters.
	// The URL-encoded version is used too many places.
	/**
	 * Clean out path variables and rawurlencode tour names
	 *
	 * @private
	 *
	 * @param {string} tourName Tour name
	 *
	 * @return {string} Processed tour name
	 */
	function cleanTourName( tourName ) {
		return mw.util.rawurlencode( tourName.replace( /^(?:\.\.\/)+/, '' ) );
	}

	/**
	 * Gets the tour module name.  This does not guarantee there is such a module.
	 *
	 * @private
	 *
	 * @param {string} tourName Tour name
	 *
	 * @return {string} Tour module name
	 */
	function getTourModuleName( tourName ) {
		return 'ext.guidedTour.tour.' + tourName;
	}

	/**
	 * Logs a dismissal event.
	 *
	 * @private
	 *
	 * @return {void}
	 */
	function logDismissal() {
		if ( currentTourState ) {
			pingServer( 'hide', guiders._lastCreatedGuiderID );
		}
	}

	/**
	 * Removes the tour cookie for a given guider ID,
	 * unless the changeCookie property of the guider is falsy.
	 *
	 * @private
	 *
	 * @param {string} guiderId id of guider
	 *
	 * @return {void}
	 */
	function removeCookie( guiderId ) {
		var guider = guiders._guiderById( guiderId );
		if ( guider.changeCookie ) {
			$.cookie( cookieName, null, cookieParams );
		}
	}

	/**
	 * Provides onClose handler called by Guiders on a user-initiated close action.
	 *
	 * Hides guider.  If they clicked the 'x' button, also ends the tour, removing the
	 * cookie.
	 *
	 * Logs event.
	 *
	 * Distinct from guider.onHide() becase that is called even if the tour ends.
	 *
	 * @private
	 *
	 * @param {Object} guider Guider object
	 * @param {boolean} isAlternativeClose true if is not the text close button (legacy)
	 * @param {string} closeType Guider string identify close method, currently
	 *  'textButton', 'xButton', 'escapeKey', or 'clickOutside'
	 *
	 * @return {boolean} true to end tour, false to dismiss
	 */
	function handleOnClose( guider, isAlternativeClose, closeType ) {
		logDismissal();

		if ( closeType === 'xButton' ) {
			removeCookie( guider.id );
		}
	}

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
	 * @private
	 *
	 * @param {Object} guider Guider object to set description on
	 * @param {string} source Source of wikitext, either 'page' for a wiki page name, or
	 *  'text' for wikitext.  In either case, the value goes in the description
	 *
	 * @return {void}
	 */
	function callApi ( guider, source ) {
		var ajaxParams, data;

		if ( source !== 'page' && source !== 'text' ) {
			mw.log( 'callApi called incorrectly' );
			return;
		}

		// don't parse if already done
		if ( guider.isParsed ) {
			recordStats( guider );
			return;
		}

		ajaxParams = {
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
		data = JSON.parse(
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

			recordStats( guider );
		}
	}

	/**
	 * Converts a message key to a parsed HTML message using jqueryMsg.
	 *
	 * @private
	 *
	 * @param {string} key Message key
	 *
	 * @return {string} HTML of parsed message
	 */
	function getMessage( key ) {
		return messageParser.parse( key ).html();
	}

	/**
	 * Gets a Guiders button specification that uses the message for the provided type
	 * and the provided callback.
	 *
	 * @private
	 *
	 * @param {string} buttonType type, currently 'next' or 'okay'
	 * @param {Function} callback Function to call if they click the button
	 * @param {HTMLElement} callback.btn Raw DOM element of the okay button
	 *
	 * @return {Object} Guiders button specification
	 */
	function getMessageButton( buttonType, callback ) {
		var buttonKey = 'guidedtour-' + buttonType + '-button';
		return {
			name: getMessage ( buttonKey ),
			onclick: function () {
				callback( this );
			},
			html: {
				'class': guiders._buttonClass + ' ' + buttonKey
			}
		};
	}

	/**
	 * Changes the button to link to the given URL, and returns it
	 *
	 * @private
	 *
	 * @param {Object} button Button spec
	 * @param {string} url URL to go to
	 * @param {string} [title] Title attribute of button
	 *
	 * @return {Object} Modified button
	 */
	function modifyLinkButton( button, url, title ) {
		if ( button.namemsg ) {
			button.name = getMessage( button.namemsg );
			delete button.namemsg;
		}

		$.extend( true, button, {
			html: {
				href: url,
				title: title
			}
		} );

		return button;
	}

	/**
	 * Converts a tour's GuidedTour button specifications to Guiders button
	 * specifications.
	 *
	 * A GuidedTour button specification can specify an action and/or use MW
	 * internationalization.
	 *
	 * This has special handling for Okay and Next, which are always last in the
	 * returned array (if present).
	 *
	 * If there is no other Okay or Next, an Okay button will be generated that hides
	 * the tour.  If both Okay and Next are present, they will be in that order.  See
	 * also gt.defineTour.
	 *
	 * Handles actions and internationalization.
	 *
	 * @private
	 *
	 * @param {Array} [buttonSpecs=[]] Button specifications as used in tour.  Elements
	 *  will be mutated.
	 * @param {boolean} allowAutomaticOkay true if and only if an okay can be generated
	 *
	 * @return {Array} Array of button specifications that Guiders expects
	 * @throws {mw.guidedTour.TourDefinitionError} On invalid actions
	 */
	function getButtons( buttonSpecs, allowAutomaticOkay ) {
		var i, okayButton, nextButton, guiderButtons, currentButton, url;

		function next() {
			guiders.next();
		}

		function endTour() {
			gt.endTour();
		}

		buttonSpecs = buttonSpecs || [];
		guiderButtons = [];
		for ( i = 0; i < buttonSpecs.length; i++ ) {
			currentButton = buttonSpecs[i];
			if ( currentButton.action !== undefined ) {
				switch ( currentButton.action ) {
					case 'next':
						nextButton = getMessageButton( 'next', next );
						break;
					case 'okay':
						if ( currentButton.onclick === undefined ) {
							throw new gt.TourDefinitionError( 'You must pass an \'onclick\' function if you use an \'okay\' action.' );
						}
						okayButton = getMessageButton( 'okay', currentButton.onclick );
						break;
					case 'end':
						okayButton = getMessageButton( 'okay', endTour );
						break;
					case 'wikiLink':
						url = mw.util.wikiGetlink( currentButton.page );
						guiderButtons.push( modifyLinkButton( currentButton, url, currentButton.page ) );
						delete currentButton.page;
						break;
					case 'externalLink':
						guiderButtons.push( modifyLinkButton( currentButton, currentButton.url ) );
						delete currentButton.url;
						break;
					default:
						throw new gt.TourDefinitionError( '\'' + currentButton.action + '\'' + ' is not a supported button action.' );
				}
				delete currentButton.action;

			} else {
				if ( currentButton.namemsg ) {
					currentButton.name = getMessage( currentButton.namemsg );
					delete currentButton.namemsg;
				}
				guiderButtons.push( currentButton );
			}
		}

		if ( allowAutomaticOkay ) {
			// Ensure there is always an okay and/or next button.  In some cases, there will not be
			// a next, since the user is prompted to do something else
			// (e.g. click 'Edit')
			if ( okayButton === undefined  && nextButton === undefined ) {
				okayButton = getMessageButton( 'okay', function () {
					gt.hideAll();
				} );
			}
		}

		if ( okayButton !== undefined ) {
			guiderButtons.push( okayButton );
		}

		if ( nextButton !== undefined ) {
			guiderButtons.push( nextButton );
		}

		return guiderButtons;
	}

	/**
	 * Clones guider options and augments with onClose field.
	 *
	 * @private
	 *
	 * @param {Object} defaultOptions Default options that are specific to this case
	 * @param {Object} options User-provided options object, taking precedence over
	 *  defaultOptions
	 *
	 * @return {Object} Augmented guider
	 */
	function augmentGuider( defaultOptions, options ) {
		return $.extend( true, {
			onClose: $.noop,
			onShow: $.noop,
			allowAutomaticOkay: true,
			changeCookie: true
		}, defaultOptions, options );
	}

	/**
	 * Gets the correct value for the current skin.
	 *
	 * This allows skin-specific values and a default fallback.
	 *
	 * @private
	 *
	 * @param {Object} options Guider options object
	 * @param {string} key Key to handle
	 *
	 * @return {string} Value to use
	 * @throws {mw.guidedTour.TourDefinitionError} When skin and fallback are both missing, or
	 *  value for key has an invalid type
	 */
	function getValueForSkin( options, key ) {
		var value = options[key], type = $.type( value );
		if ( type === 'string' ) {
			return value;
		} else if ( type === 'object' ) {
			if ( value[skin] !== undefined ) {
				return value[skin];
			} else if ( value.fallback !== undefined ) {
				return value.fallback;
			} else {
				throw new gt.TourDefinitionError( 'No \'' + key + '\' value for skin \'' + skin + '\' or for \'fallback\'' );
			}
		} else {
			throw new gt.TourDefinitionError( 'Value for \'' + key + '\' must be an object or a string.' );
		}
	}

	/**
	 * Determines whether we should horizontally flip the guider due to LTR/RTL
	 *
	 * Considers the HTML element's dir attribute and body LTR/RTL classes in addition
	 * to parameter.
	 *
	 * @private
	 *
	 * @param {boolean} isExtensionDefined true if the tour is extension-defined,
	 *  false otherwise
	 *
	 * @return {boolean} true if steps should be flipped, false otherwise
	 */
	function getShouldFlipHorizontally( isExtensionDefined ) {
		var tourDirection, interfaceDirection, siteDirection, $body;

		$body = $( document.body );

		// Main direction of the site
		siteDirection = $body.is( '.sitedir-ltr' ) ? 'ltr' : 'rtl';

		// Direction the interface is being viewed in.
		// This can be changed by user preferences or uselang
		interfaceDirection = $( 'html' ).attr( 'dir' );

		// Direction the tour is assumed to be written for
		tourDirection = isExtensionDefined ? 'ltr' : siteDirection;

		// We flip if needed to match the interface direction
		return tourDirection !== interfaceDirection;
	}

	/**
	 * Internal function used for initializing a guider.  Other methods call this after all augmentation is complete.
	 *
	 * @private
	 *
	 * @param {Object} options Guider options object augmented with defaults
	 * @param {boolean} shouldFlipHorizontally true to flip requested position horizontally
	 *  before calling guiders, false otherwise
	 *
	 * @return {boolean} true, on success; throws otherwise
	 * @throws {mw.guidedTour.TourDefinitionError} On invalid input
	 */
	function initializeGuiderInternal( options, shouldFlipHorizontally ) {
		var passedInOnClose = options.onClose, passedInOnShow;
		options.onClose = function () {
			passedInOnClose.apply ( this, arguments );
			return handleOnClose.apply( this, arguments );
		};

		passedInOnShow = options.onShow;
		options.onShow = function () {
			// Unlike the above the order is different.  This ensures
			// handleOnShow (which does not return a value) always runs, and
			// the user-provided function (if any) can return a value.
			handleOnShow.apply( this, arguments );
			return passedInOnShow.apply( this, arguments );
		};

		if ( options.titlemsg ) {
			options.title = getMessage( options.titlemsg );
		}
		delete options.titlemsg;

		if ( options.descriptionmsg ) {
			options.description = getMessage( options.descriptionmsg );
		}
		delete options.descriptionmsg;

		options.buttons = getButtons( options.buttons, options.allowAutomaticOkay );
		delete options.allowAutomaticOkay;

		if ( options.attachTo !== undefined ) {
			options.attachTo = getValueForSkin( options, 'attachTo' );
		}

		if ( options.position !== undefined ) {
			options.position = getValueForSkin( options, 'position' );
			if ( shouldFlipHorizontally ) {
				options.position = guiders.getFlippedPosition( options.position, {
					horizontal: true
				} );
			}
		}

		guiders.initGuider( options );

		return true;
	}

	/**
	 * Listen for events that could potentially be logged (depending on shouldLog)
	 *
	 * @private
	 *
	 * @return {void}
	 */
	function setupGuiderListeners() {
		$( document.body ).on( 'click', '.guider a[href]', function () {
			var buttonSelector, action;

			buttonSelector = '.' + guiders._buttonClass.split( /\s+/ ).join( '.' );
			action = $( this ).is( buttonSelector ) ? 'button-click' : 'link-click';
			pingServer( action, $( this ).parents( '.guider ').attr( 'id' ) );
		} );
	}

	/**
	 * Guiders has a window resize and document ready listener.
	 *
	 * However, we're adding some MW-specific code. Currently, this listens for a
	 * custom event from the WikiEditor extension, which fires after the extension's
	 * async loop finishes. If WikiEditor is not running this event just won't fire.
	 *
	 * @private
	 *
	 * @return {void}
	 */
	function setupRepositionListeners() {
		$( '#wpTextbox1' ).on( 'wikiEditor-toolbar-doneInitialSections', function () {
			guiders.reposition();
		} );
	}

	/**
	 * Internal initialization of guiders and guidedtour, called once after singleton
	 * is built.
	 *
	 * @private
	 *
	 * @return {void}
	 */
	function initialize() {
		setupLogging();

		guiders._buttonClass = 'mw-ui-button mw-ui-primary';

		// cookie the users when they are in the tour
		cookieName = mw.config.get( 'wgCookiePrefix' ) + '-mw-tour';
		cookieParams = { path: '/' };

		// Show X button
		guiders._defaultSettings.xButton = true;

		guiders._defaultSettings.closeOnEscape = true;
		guiders._defaultSettings.closeOnClickOutside = true;
		guiders._defaultSettings.flipToKeepOnScreen = true;

		$( document ).ready( function () {
			setupRepositionListeners();
			setupGuiderListeners();
		} );
	}

	gt = mw.guidedTour = {
		/**
		 * Parses tour ID into an object with name and step keys.
		 *
		 * @param {string} tourId ID of tour
		 *
		 * @return {Object|null} Tour info object, or null if invalid input
		 * @return {string} return.name Tour name
		 * @return {string} return.step Tour step
		 */
		parseTourId: function ( tourId ) {
			// Keep in sync with regex in GuidedTourHooks.php
			var TOUR_ID_REGEX = /^gt-([^.\-]+)-(\d+)$/,
				tourMatch, tourName, tourStep;

			if ( typeof tourId !== 'string' ) {
				return null;
			}

			tourMatch = tourId.match( TOUR_ID_REGEX );
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
		},

		/**
		 * Serializes tour information into a string
		 *
		 * @param {Object} tourInfo
		 * @param {string} tourInfo.name Tour name
		 * @param {number|string} tourInfo.step Tour step
		 *
		 * @return {string} ID of tour, or null if invalid input
		 */
		makeTourId: function( tourInfo ) {
			if ( !$.isPlainObject( tourInfo ) ) {
				return null;
			}

			return 'gt-' + tourInfo.name + '-' + tourInfo.step;
		},

		/**
		 * Launch a tour.  Tours start themselves, but this allows one tour to launch
		 * another.
		 *
		 * It will first try loading a tour module, then fall back on an on-wiki tour.
		 * This means the caller doesn't need to know how it's implemented (which could
		 * change).
		 *
		 * launchTour is used to load the tour specified in the URL too.  This case
		 * does not require an extra request for an extension-defined tour since it
		 * is already loaded.
		 *
		 * @param {string} tourName Name of tour
		 * @param {string} [tourId='gt-' + tourName + '-1'] ID of tour
		 *
		 * @return {void}
		 */
		launchTour: function ( tourName, tourId ) {
			var tourModuleName,
			onWikiTourUrl,
			MW_NS_TOUR_PREFIX = 'MediaWiki:Guidedtour-tour-';

			if ( !tourId ) {
				tourId = gt.makeTourId( {
					name: tourName,
					step: '1'
				} );
			}

			// Called if we successfully loaded the tour
			function resume() {
				guiders.resume( tourId );
			}

			tourModuleName = getTourModuleName( tourName );
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
					.fail( function ( jqXHR, settings, exception ) {
						var message = 'Failed to load tour ' + tourName;
						if ( exception ) {
							mw.log( message, exception );
						} else {
							mw.log( message );
						}
					});
			}
		},

		/**
		 * Attempts to automatically launch a tour based on the environment
		 *
		 * If the query string has a tour parameter, the method attempts to use that.
		 * Otherwise, the method tries to use the cookie.
		 *
		 * If both fail, it does nothing.
		 *
		 * @return {void}
		 */
		launchTourFromEnvironment: function () {
			// Tour is either in the query string or cookie (prefer query string)
			var tourName = mw.util.getParamValue( 'tour' ), tourId,
				tourInfo, step;
			//clean out path variables
			if ( tourName ) {
				tourName = cleanTourName( tourName );
			}
			if ( tourName !== null && tourName.length !== 0 ) {
				step = mw.util.getParamValue( 'step' );
				if ( step === null || step === '' ) {
					step = '1';
				}
				tourId = gt.makeTourId( {
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
		},

		/**
		 * Sets the tour cookie, given a tour name and optionally, a step.
		 *
		 * You can use this when you want the tour to be displayed on a future page.
		 *
		 * @param {string} name Tour name
		 * @param {number|string} [step=1] Tour step
		 *
		 * @return {void}
		 */
		setTourCookie: function ( name, step ) {
			var id;
			step = step || 1;
			id = gt.makeTourId( {
				name: name,
				step: step
			} );
			$.cookie( cookieName, id, cookieParams );
		},

		/**
		 * @deprecated
		 *
		 * There is no longer a need to call this public method, and it may be
		 * removed in the future.
		 */
		recordStats: $.noop,

		/**
		 * Ends the tour, then logs, passing a step of 'end'
		 *
		 * @return {void}
		 */
		endTour: function () {
			logDismissal();
			removeCookie( guiders._currentGuiderID );
			guiders.hideAll();
		},

		/**
		 * Hides the guider(s), then logs, passing a step of 'hide'
		 *
		 * @return {void}
		 */
		hideAll: function () {
			logDismissal();
			guiders.hideAll();
		},

		// Begin onShow bindings section
		//
		// These are used as the value of the onShow field of a step.

		/**
		 * Parses description as wikitext
		 *
		 * Add this to onShow.
		 *
		 * @param {Object} guider Guider object to set description on
		 *
		 * @return {void}
		 */
		parseDescription: function ( guider ) {
			callApi( guider, 'text' );
		},

		/**
		 * Parses a wiki page and uses the HTML as the description.
		 *
		 * To use this, put the page name as the description, and use this as the
		 * value of onShow.
		 *
		 * @param {Object} guider Guider object to set description on
		 *
		 * @return {void}
		 */
		getPageAsDescription: function ( guider ) {
			callApi( guider, 'page' );
		},

		// End onShow bindings section

		//
		// Begin shouldSkip bindings section
		//
		// These are utility functions useful in constructing a function that can be passed
		// as the shouldSkip parameter to a step.
		//

		/**
		 * Checks whether user is on a particular wiki page.
		 *
		 * @param {string} pageName Expected page name
		 *
		 * @return {boolean} true if the page name is a strict match, false otherwise
		 */
		isPage: function ( pageName ) {
			return mw.config.get( 'wgPageName' ) === pageName;
		},

		/**
		 * Checks whether the query and pageName match the provided ones.
		 *
		 * It will return true if and only if the actual query string has all of the
		 * mappings from queryParts (the actual query string may be a superset of the
		 * expected), and pageName (optional) is exactly equal to wgPageName.
		 *
		 * If pageName is falsy, the page name will not be considered in any way.
		 *
		 * @param {Object} queryParts Object mapping expected query
		 *  parameter names (string) to expected values (string)
		 * @param {string} [pageName] Page name
		 *
		 * @return {boolean} true if and only if there is a match per above
		 */
		hasQuery: function ( queryParts, pageName ) {
			if ( pageName && mw.config.get( 'wgPageName' ) !== pageName ) {
				return false;
			}

			for ( var qname in queryParts ) {
				if ( mw.util.getParamValue( qname ) !== queryParts[qname] ) {
					return false;
				}
			}
			return true;
		},

		/**
		 * Checks whether they are editing.  Does not include previewing.
		 *
		 * @return {boolean} true if and only if they are on the edit action
		 */
		isEditing: function () {
			return mw.config.get( 'wgAction' ) === 'edit';
		},

		/**
		 * Checks whether they are previewing or reviewing changes (after clicking "Show changes")
		 *
		 * @return {boolean} true if and only if they are reviewing
		 */
		isReviewing: function () {
			return mw.config.get( 'wgAction' ) === 'submit';
		},


		/**
		 * Checks whether they just saved an edit.
		 *
		 * @return {boolean} true if they just saved an edit, false otherwise
		 */
		isPostEdit: function () {
			return mw.config.get( 'wgPostEdit' );
		},

		// End shouldSkip bindings section

		/**
		 * Gets step of tour from querystring
		 *
		 * @return {string} Step
		 */
		getStep: function () {
			return mw.util.getParamValue( 'step' );
		},

		/**
		 * Resumes an already loaded tour
		 *
		 * @param {string} tourName Tour name
		 *
		 * @return {void}
		 */
		resumeTour: function ( tourName ) {
			var step = gt.getStep() || 0, cookieValue;
			// Bind failure step (in case there are problems).
			guiders.failStep = gt.makeTourId( {
				name: tourName,
				step: 'fail'
			} );

			cookieValue = $.cookie( cookieName );
			if ( ( step === 0 ) && cookieValue !== null ) {
				// start from cookie position
				if ( guiders.resume( cookieValue ) ) {
					return;
				}
			}

			if ( step === 0 ) {
				step = 1;
			}
			// start from step specified
			guiders.resume( gt.makeTourId( {
				name: tourName,
				step: step
			} ) );
		},

		/**
		 * Creates a tour based on an object specifying it, but does not show
		 * it immediately
		 *
		 * If the user clicks Okay or Next, the applicable action (see below)
		 * will occur.
		 *
		 * If there would otherwise be neither an Okay nor a Next button on a
		 * particular guider, it will have an Okay button
		 * (but see allowAutomaticOkay).  This will hide the guider if clicked.
		 *
		 * If input to defineTour is invalid, it will throw
		 * mw.guidedTour.TourDefinitionError.
		 *
		 * @param {Object} tourSpec Specification of tour
		 * @param {string} tourSpec.name Name of tour
		 *
		 * @param {boolean} [tourSpec.isSinglePage=false] Tour is used on a single
		 *  page tour. This disables tour cookies.
		 * @param {boolean} [tourSpec.shouldLog=false] Whether to log events to
		 *  EventLogging
		 *
		 * @param {Array} tourSpec.steps Array of steps
		 *
		 * The most commonly used keys in each step are listed below:
		 *
		 * @param {string} tourSpec.steps.title Title of guider.  Used only
		 *  for on-wiki tours
		 * @param {string} tourSpec.steps.titlemsg Message key for title of
		 *  guider.  Used only for extension-defined tours
		 *
		 * @param {string} tourSpec.steps.description Description of guider.
		 *  By default, this is just HTML.
		 * @param {string} tourSpec.steps.descriptionmsg Message key for
		 *  description of guider.  Used only for extension-defined tours.
		 *
		 * @param {string|Object} tourSpec.steps.position A positional string specifying
		 *  what part of the element the guider attaches to.  One of 'topLeft',
		 *  'top', 'topRight', 'rightTop', 'right', 'rightBottom', 'bottomRight',
		 *  'bottom', 'bottomLeft', 'leftBottom', 'left', 'leftTop'
		 *
		 *  Or:
		 *
		 *     {
		 *         fallback: 'defaultPosition'
		 *         particularSkin: 'otherPosition',
		 *         anotherSkin: 'anotherPosition'
		 *     }
		 *
		 *  particularSkin should be replaced with a MediaWiki skin name, such as
		 *  monobook.  There can be entries for any number of skins.
		 *  'defaultPosition' is used if there is no custom value for a skin.
		 *
		 *  The position is automatically horizontally flipped if needed (LTR/RTL
		 *  interfaces).
		 *
		 * @param {string|Object} tourSpec.steps.attachTo The selector for an element to
		 *  attach to, or an object for that purpose with the same format as
		 *  position
		 *
		 * @param {Function} [tourSpec.steps.shouldSkip] Function returning a
		 *  boolean, which specifies whether to skip the current step based on the
		 *  page state
		 * @param {boolean} tourSpec.steps.shouldSkip.return true to skip, false
		 *  otherwise
		 *
		 * @param {Function} [tourSpec.steps.onShow] Function to execute immediately
		 *  before the guider is shown.  The most commonly used values are:
		 *
		 *  - gt.parseDescription - Treat description as wikitext
		 *  - gt.getPageAsDescription - Treat description as the name of a description
		 *  page on the wiki
		 *
		 * @param {boolean} [tourSpec.steps.allowAutomaticOkay=true] By default, if
		 * you do not specify an Okay or Next button, an Okay button will be generated.
		 *
		 * To suppress this, set allowAutomaticOkay to false for the guider.
		 *
		 * @param {boolean} [tourSpec.steps.closeOnClickOutside=true] Close the
		 *  guider when the user clicks elsewhere on screen
		 *
		 * @param {Array} tourSpec.steps.buttons Buttons for step.  See also above
		 *  regarding button behavior and defaults.  Each button can have:
		 *
		 * @param {string} tourSpec.steps.buttons.name Text of button.  Used only
		 *  for on-wiki tours
		 * @param {string} tourSpec.steps.buttons.namemsg Message key for text of
		 *  button.  Used only for extension-defined tours
		 *
		 * @param {Function} tourSpec.steps.buttons.onclick Function to execute
		 *  when button is clicked
		 *
		 * @param {"next"|"okay"|"end"|"wikiLink"|"externalLink"} tourSpec.steps.buttons.action
		 *  Action keyword.  For actions listed below, you do not need to manually
		 *  specify button name and onclick.
		 *
		 *  Instead, you can pass a defined action as part of the buttons array.  The
		 *  actions currently supported are:
		 *
		 *  - next - Goes to the next step.
		 *  - okay - An arbitrary function is used for okay button.  This must have
		 *    an accompanying 'onclick':
		 *
		 *     {
		 *         action: 'okay',
		 *         onclick: function () {
		 *		// Do something...
		 *         }
		 *     }
		 *
		 *  - end - Ends the tour.
		 *  - wikiLink - links to a page on the same wiki
		 *  - externalLink - links to an external page
		 *
		 *  A button action with no parameters looks like:
		 *
		 *     {
		 *         action: 'next'
		 *     }
		 *
		 * Multiple action fields for a single button are not possible.
		 *
		 * @param {string} tourSpec.steps.buttons.page Page to link to, only for
		 *  the wikiLink action
		 * @param {string} tourSpec.steps.buttons.url URL to link to, only for the
		 *  externalLink action
		 *
		 * @return {boolean} true, on success; throws otherwise
		 * @throws {mw.guidedTour.TourDefinitionError} On invalid input
		 */
		defineTour: function ( tourSpec ) {
			var steps, stepInd = 0, stepCount, step, id, defaults = {},
			isExtensionDefined, shouldFlipHorizontally, moduleName;

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

			if ( tourSpec.isSinglePage ) {
				defaults.changeCookie = false;
			}

			moduleName = getTourModuleName( tourSpec.name );
			isExtensionDefined = ( mw.loader.getState( moduleName ) !== null );
			shouldFlipHorizontally = getShouldFlipHorizontally( isExtensionDefined );

			stepCount = steps.length;
			for ( stepInd = 1; stepInd <= stepCount; stepInd++ ) {
				step = augmentGuider( defaults, steps[stepInd - 1] );

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

				initializeGuiderInternal( step, shouldFlipHorizontally );
			}

			// Set the current tour name after all the guiders initialize successfully
			currentTourState = {
				name: tourSpec.name,
				shouldLog: tourSpec.shouldLog || false,
				stepCount: stepCount
			};

			return true;
		},

		/**
		 * Initializes a guider
		 *
		 * This method will be removed, so you should use gt.defineTour instead.
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
		 * @param {Object} options Options object matching the gt.defineTour step, except as noted above
		 *
		 * @return {boolean} true, on success; throws otherwise
		 * @throws {mw.guidedTour.TourDefinitionError} On invalid input
		 */
		initGuider: function ( options ) {
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

			return initializeGuiderInternal( augmentGuider( {}, options ), false );
		},

		/*
		 * Returns cookie configuration, for testing only.
		 *
		 * @private
		 *
		 * @return {object} cookie configuration
		 */
		getCookieConfiguration: function () {
			return {
				name: cookieName,
				parameters: cookieParams
			};
		},

		// Keep after regular methods.
		// jsduck assumes methods belong to the classes they follow in source
		// code order.
		/**
		 * Error subclass for errors that occur during tour definition
		 *
		 * @class mw.guidedTour.TourDefinitionError
		 * @extends Error
		 *
		 * @constructor
		 *
		 * @param {string} message Error message text
		 **/
		TourDefinitionError: function ( message ) {
			this.message = message;
		}
	};

	gt.TourDefinitionError.prototype.toString = function () {
		return 'TourDefinitionError: ' + this.message;
	};
	gt.TourDefinitionError.prototype.constructor = gt.TourDefinitionError;

	initialize();
} ( window, document, jQuery, mediaWiki, mediaWiki.libs.guiders ) );
