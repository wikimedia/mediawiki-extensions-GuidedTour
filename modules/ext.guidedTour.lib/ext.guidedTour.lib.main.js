/* global ve */
/**
 * @classdesc GuidedTour public API
 *
 * Set as mw.guidedTour and often aliased to gt locally
 *
 * @author Terry Chay <tchay@wikimedia.org>
 * @author Matt Flaschen <mflaschen@wikimedia.org>
 * @author Ori Livneh <olivneh@wikimedia.org>
 * @author Rob Moen <rmoen@wikimedia.org>
 * @author S Page <spage@wikimedia.org>
 * @author Sam Smith <git@samsmith.io>
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
( function ( guiders ) {
	'use strict';

	const gt = mw.guidedTour,
		internal = gt.internal;
	let cookieName, cookieParams;
	// Initialized to false at page load
	// Will be set true any time postEdit fires, including right after
	// legacy wgPostEdit variable is set to true.
	let isPostEdit = false;

	/**
	 * Returns the current user state, initalizing it if needed
	 *
	 * @private
	 *
	 * @return {Object} user state object.  If there is none, or the format was
	 *  invalid, returns a skeleton state object from
	 *  mw.guidedTour.internal#getInitialUserStateObject
	 */
	function getCookieState() {
		const cookieValue = mw.cookie.get( cookieName );
		const parsed = internal.parseUserState( cookieValue );
		if ( parsed !== null ) {
			return parsed;
		} else {
			return internal.getInitialUserStateObject();
		}
	}

	/**
	 * Returns the current combined user state (cookie state and server-launched state)
	 * Basically, this acts like the cookie state, except the server can specify
	 * tours that take precedence via a $wg.
	 *
	 * @private
	 *
	 * @return {Object} combined state object.  If there is none, or the format was
	 * invalid, returns a skeleton state object from
	 * mw.guidedTour.internal#getInitialUserStateObject
	 */
	function getUserState() {
		const cookieState = getCookieState(),
			serverState = mw.config.get( 'wgGuidedTourLaunchState' );
		let state = cookieState;

		if ( serverState !== null ) {
			state = $.extend( true, state, serverState );
		}

		return state;

	}

	/**
	 * Removes a tour from the cookie
	 *
	 * @private
	 *
	 * @param {string} tourName name of tour to remove
	 */
	function removeTourFromUserStateByName( tourName ) {
		const parsedCookie = getCookieState();
		delete parsedCookie.tours[ tourName ];
		mw.cookie.set( cookieName, JSON.stringify( parsedCookie ), cookieParams );
	}

	/**
	 * Launch tour from given user state
	 *
	 * @private
	 *
	 * @param {Object} state State that specifies the tour progress
	 *
	 * // @return {boolean} Whether a tour was launched
	 */
	function launchTourFromState( state ) {
		const candidateTours = [];

		for ( const tourName in state.tours ) {
			candidateTours.push( {
				name: tourName,
				step: state.tours[ tourName ].step,
			} );
		}

		const tourNames = candidateTours.map( ( el ) => el.name );

		internal.loadMultipleTours( tourNames )
			.always( () => {
				let tourName, max, currentStart;

				// This value is before 1970, but is a simple way
				// to ensure the comparison below always works.
				max = {
					startTime: -1,
				};

				// Not all the tours in the cookie necessarily
				// loaded successfully, but the defined tours did.
				// So we make sure it is defined and in the user
				// state.
				for ( tourName in internal.definedTours ) {
					if (
						state.tours[ tourName ] !== undefined &&
						gt.shouldShowTour( {
							tourName: tourName,
							userState: state,
							pageName: mw.config.get( 'wgPageName' ),
							articleId: mw.config.get( 'wgArticleId' ),
							condition: internal.definedTours[ tourName ].showConditionally,
						} )
					) {
						currentStart = state.tours[ tourName ].startTime || 0;
						if ( currentStart > max.startTime ) {
							max = {
								name: tourName,
								step: state.tours[ tourName ].step,
								startTime: currentStart,
							};
						}
					}
				}

				if ( max.name !== undefined ) {
					// Launch the most recently started tour
					// that meets the conditions.
					gt.launchTour( max.name, gt.makeTourId( max ) );
				}
			} );
	}

	// TODO (mattflaschen, 2013-07-10): Known issue: This runs too early on a direct
	// visit to a veaction=edit page.  This probably affects other JS-generated
	// interfaces too.
	/**
	 * Initializes guiders and shows tour, starting at the specified step.
	 * Does not check conditions, so that should already be done
	 *
	 * @private
	 *
	 * @param {string} tourName name of tour
	 * @param {string} tourId id to start at
	 * @throws {mw.guidedTour.IllegalArgumentError} If the tour ID is not consistent
	 *   with the tour name, or does not refer to a valid step
	 */
	function showTour( tourName, tourId ) {
		const tour = internal.definedTours[ tourName ];

		const tourInfo = gt.parseTourId( tourId );
		if ( tourInfo.name !== tourName ) {
			throw new gt.IllegalArgumentError( 'The tour ID "' + tourId + '" is not part of the tour "' + tourName + '".' );
		}

		tour.showStep( tourInfo.step );
	}

	/**
	 * Guiders has a window resize and document ready listener.
	 *
	 * However, we're adding some MW-specific code. Currently, this listens for a
	 * custom event from the WikiEditor extension, which fires after the extension's
	 * async loop finishes. If WikiEditor is not running this event just won't fire.
	 *
	 * @private
	 */
	function setupRepositionListeners() {
		$( '#wpTextbox1' ).on( 'wikiEditor-toolbar-doneInitialSections', guiders.reposition );
		mw.hook( 've.skinTabSetupComplete' ).add( guiders.reposition );
	}

	/**
	 * Listen for events that may mean a tour should transition.
	 * Currently this listens for some custom events from VisualEditor.
	 *
	 * @private
	 * @memberof mw.guidedTour
	 */
	function setupStepTransitionListeners() {
		// TODO (mattflaschen, 2014-03-17): Temporary hack, until
		// there are tour-level transition listeners.
		// Will also change as mediawiki.libs.guiders module is refactored.
		/**
		 * Checks for a transition after a minimal timeout
		 *
		 * @param {mw.guidedTour.TransitionEvent} transitionEvent event that triggered
		 *  the check
		 * @memberof mw.guidedTour
		 */
		function transition( transitionEvent ) {
			// I found this timeout necessary when testing, probably to give the
			// browser queue a chance to do pending DOM rendering.
			setTimeout( () => {
				if ( guiders._currentGuiderID === null ) {
					// Ignore transitions if there is no active tour.
					return;
				}

				const currentStepInfo = gt.parseTourId( guiders._currentGuiderID );
				if ( currentStepInfo === null ) {
					mw.log.warn( 'Invalid _currentGuiderID.  Returning early' );
					return;
				}

				const tour = internal.definedTours[ currentStepInfo.name ];
				const currentStep = tour.getStep( currentStepInfo.step );
				const nextStep = currentStep.checkTransition( transitionEvent );
				if ( nextStep !== currentStep && nextStep !== null ) {
					tour.showStep( nextStep );
				}

			}, 0 );
		}

		// The next two are handled differently since they also require
		// settings an internal boolean.
		// TODO (mattflaschen, 2014-04-01): Hack pending tour-level listeners.
		mw.hook( 'postEdit' ).add( () => {
			const transitionEvent = new gt.TransitionEvent();
			transitionEvent.type = gt.TransitionEvent.MW_HOOK;
			transitionEvent.hookName = 'postEdit';
			transitionEvent.hookArguments = [];

			isPostEdit = true;
			transition( transitionEvent );
		} );
	}

	/**
	 * Internal initialization of guiders and guidedtour, called once after singleton
	 * is built.
	 *
	 * @private
	 */
	function initialize() {
		// GuidedTour uses cookies to keep the user's progress when they are in the
		// tour, unless it's single-page.
		cookieName = '-mw-tour';
		cookieParams = {
			expires: null, // null means to use a session cookie.
			sameSite: 'Lax',
		};

		// Show X button
		guiders._defaultSettings.xButton = true;

		guiders._defaultSettings.autoFocus = true;
		guiders._defaultSettings.closeOnEscape = true;
		guiders._defaultSettings.closeOnClickOutside = true;
		guiders._defaultSettings.flipToKeepOnScreen = true;

		$( () => {
			setupRepositionListeners();
			setupStepTransitionListeners();
		} );
	}

	// Add external API (internal API is at gt.internal)
	// Most, but not all, of this is public (non-public ones use standard
	// @private marking).
	Object.assign( gt, {
		/**
		 * Parses tour ID into an object with name and step keys.
		 *
		 * @memberof mw.guidedTour#
		 *
		 * @param {string} tourId ID of tour/step combination
		 *
		 * @return {Object|null} Tour info object, or null if invalid input
		 * @return {string} return.name Tour name
		 * @return {string} return.step Tour step, always a string, but
		 *   either textual (e.g. 'preview') or numeric (e.g. '5')
		 */
		parseTourId: function ( tourId ) {
			// Keep in sync with regex in GuidedTourHooks.php
			const TOUR_ID_REGEX = /^gt-([^.-]+)-([^.-]+)$/;

			if ( typeof tourId !== 'string' ) {
				return null;
			}

			const tourMatch = tourId.match( TOUR_ID_REGEX );
			if ( !tourMatch ) {
				return null;
			}

			const tourName = tourMatch[ 1 ];
			const tourStep = tourMatch[ 2 ];

			if ( tourName.length === 0 ) {
				return null;
			}

			return {
				name: tourName,
				step: tourStep,
			};
		},

		/**
		 * Serializes tour information into a string
		 *
		 * @memberof mw.guidedTour#
		 *
		 * @param {Object} tourInfo
		 * @param {string} tourInfo.name Tour name
		 * @param {number|string} tourInfo.step Tour step, which can be a string,
		 *   such as 'preview', or numeric, as either a string ('5') or a
		 *   number (5).
		 *
		 * @return {string|null} ID of tour, or null if invalid input
		 */
		makeTourId: function ( tourInfo ) {
			if ( !$.isPlainObject( tourInfo ) ) {
				return null;
			}

			return 'gt-' + tourInfo.name + '-' + tourInfo.step;
		},

		/**
		 * Launch a tour.  Tours start automatically if the environment is present
		 * (user string or cookie).
		 *
		 * However, this method allows one tour to launch another.  It also allows
		 * callers to launch a tour on demand.
		 *
		 * The tour will only be shown if allowed by the specification (see defineTour).
		 *
		 * It will first try loading a tour module, then fall back on an on-wiki tour.
		 * This means the caller doesn't need to know how it's implemented (which could
		 * change).
		 *
		 * launchTour is used to load the tour specified in the URL too.  This case
		 * does not require an extra request for an extension-defined tour since it
		 * is already loaded.
		 *
		 * `mw.guidedTour.launcher.launchTour` should always be used over this method.
		 *
		 * @private
		 *
		 * @param {string} tourName Name of tour
		 * @param {string|null} [tourId='gt-' + tourName + '-' + step] ID of tour
		 *   and step.  Omitted or null means to start the tour from the beginning.
		 */
		launchTour: function ( tourName, tourId ) {
			internal.loadTour( tourName ).then( () => {
				const tour = internal.definedTours[ tourName ];

				if ( tour && gt.shouldShowTour( {
					tourName: tourName,
					userState: getUserState(),
					pageName: mw.config.get( 'wgPageName' ),
					articleId: mw.config.get( 'wgArticleId' ),
					condition: tour.showConditionally,
				} ) ) {
					if ( tourId ) {
						showTour( tourName, tourId );
					} else {
						tour.start();
					}
				}
			} );
		},

		/**
		 * Attempts to launch a tour from the query string (tour parameter)
		 *
		 * @memberof mw.guidedTour#
		 *
		 * @return {boolean} Whether a tour was launched
		 */
		launchTourFromQueryString: function () {
			const tourName = mw.util.getParamValue( 'tour' );

			if ( tourName !== null && tourName.length !== 0 ) {
				const step = gt.getStepFromQuery();
				let tourId;
				if ( step !== null && step !== '' ) {
					tourId = gt.makeTourId( {
						name: tourName,
						step: step,
					} );
				} else {
					tourId = null;
				}

				gt.launchTour( tourName, tourId );

				return true;
			}

			return false;
		},

		/**
		 * Attempts to launch a tour from combined user state (cookie + tours launched
		 * directly by server)
		 *
		 * @memberof mw.guidedTour#
		 *
		 * @return {boolean} Whether a tour was launched
		 */
		launchTourFromUserState: function () {
			const state = getUserState();
			return launchTourFromState( state );
		},

		/**
		 * Attempts to automatically launch a tour based on the environment
		 *
		 * If the query string has a tour parameter, the method attempts to use that.
		 *
		 * Otherwise, the method tries to use the GuidedTour cookie.  It checks which tours
		 * are applicable to the current page.  If more than one is, this method
		 * loads the most recently started tour.
		 *
		 * If both fail, it does nothing.
		 *
		 * @memberof mw.guidedTour#
		 */
		launchTourFromEnvironment: function () {
			// Tour is either in the query string or cookie (prefer query string)

			if ( this.launchTourFromQueryString() ) {
				return;
			}

			this.launchTourFromUserState();
		},

		/**
		 * Sets the tour cookie, given a tour name and optionally, a step.
		 *
		 * You can use this when you want the tour to be displayed on a future page.
		 * If there is currently no cookie, it will set the start time.  This
		 * will not be done if only the step is changing.
		 *
		 * This does not take into account isSinglePage.
		 *
		 * @memberof mw.guidedTour#
		 *
		 * @param {string} name Tour name
		 * @param {number|string} [step=1] Tour step
		 */
		setTourCookie: function ( name, step ) {
			step = step || 1;

			gt.updateUserStateForTour( {
				tourInfo: {
					name: name,
					step: step,
				},
				wasShown: false,
			} );
		},

		// TODO (mattflaschen, 2014-04-04): Cleanup and move into Tour
		/**
		 * Ends the tour, removing user's state
		 *
		 * @memberof mw.guidedTour#
		 *
		 * @param {string} [tourName] tour to end, defaulting to most recent one
		 *  that showed a guider
		 */
		endTour: function ( tourName ) {
			if ( tourName !== undefined ) {
				removeTourFromUserStateByName( tourName );
			} else {
				const tourId = guiders._currentGuiderID;
				const tourInfo = gt.parseTourId( tourId );
				tourName = tourInfo.name;
				const guider = guiders._guiderById( tourId );
				gt.removeTourFromUserStateByGuider( guider );
			}

			const tour = internal.definedTours[ tourName ];
			if ( tour.currentStep !== null ) {
				tour.currentStep.unregisterMwHooks();
			}

			guiders.hideAll();
		},

		/**
		 * Hides the guider(s)
		 *
		 * @memberof mw.guidedTour#
		 */
		hideAll: function () {
			guiders.hideAll();
		},

		// Begin onShow bindings section
		//
		// These are used as the value of the onShow field of a step.
		// These are deprecated.  To allow async API calls, they are now
		// implemented another way in mw.GuidedTour.Step, but this is a temporary
		// backwards compatibility shim.
		/**
		 * Parses description as wikitext
		 *
		 * Add this to onShow.
		 *
		 * @memberof mw.guidedTour#
		 * @method
		 * @deprecated
		 *
		 * @param {Object} guider Guider object to set description on
		 */
		parseDescription: 'parseDescription is not a real function',

		// Do not use mw.log.deprecate for this, since there is some magic
		// in StepBuilder that accesses it to check equality.
		/**
		 * Parses a wiki page and uses the HTML as the description.
		 *
		 * To use this, put the page name as the description, and use this as the
		 * value of onShow.
		 *
		 * @memberof mw.guidedTour#
		 * @method
		 * @deprecated
		 *
		 * @param {Object} guider Guider object to set description on
		 */
		getPageAsDescription: 'getPageAsDescription is not a real function',

		// End onShow bindings section

		//
		// Begin transition helpers
		//
		// These are utility functions useful in determining whether a step should
		// transition (e.g. move to a new step or hide the guider), and if so what
		// to do.
		/**
		 * Checks whether user is on a particular wiki page.
		 *
		 * @memberof mw.guidedTour#
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
		 * @memberof mw.guidedTour#
		 *
		 * @param {Object} queryParts Object mapping expected query
		 *  parameter names (string) to expected values (string)
		 * @param {string} [pageName] Page name
		 *
		 * @return {boolean} true if and only if there is a match per above
		 */
		hasQuery: function ( queryParts, pageName ) {
			let qname;

			if ( pageName && mw.config.get( 'wgPageName' ) !== pageName ) {
				return false;
			}

			for ( qname in queryParts ) {
				if ( mw.util.getParamValue( qname ) !== queryParts[ qname ] ) {
					return false;
				}
			}
			return true;
		},

		/**
		 * Checks if the user is editing, with either wikitext or the
		 * VisualEditor.  Does not include previewing.
		 *
		 * @memberof mw.guidedTour#
		 *
		 * @return {boolean} true if and only if they are actively editing
		 */
		isEditing: function () {
			return gt.isEditingWithWikitext() || gt.isEditingWithVisualEditor();
		},

		/**
		 * Checks if the user is editing with wikitext.  Does not include previewing.
		 *
		 * @memberof mw.guidedTour#
		 *
		 * @return {boolean} true if and only if they are on the edit action
		 */
		isEditingWithWikitext: function () {
			return mw.config.get( 'wgAction' ) === 'edit';
		},

		/**
		 * Checks if the user is editing with VisualEditor.  This is only true if
		 * the surface is actually open for edits.
		 *
		 * Use isVisualEditorOpen instead if you want to check if there is a
		 * VisualEditor instance on the page.
		 *
		 * @memberof mw.guidedTour#
		 * @see mw.guidedTour#isVisualEditorOpen
		 *
		 * @return {boolean} true if and only if they are actively editing with VisualEditor
		 */
		isEditingWithVisualEditor: function () {
			return $( '.ve-ce-documentNode[contenteditable="true"]' ).length > 0;
		},

		/**
		 * Checks whether VisualEditor is open
		 *
		 * @memberof mw.guidedTour#
		 *
		 * @return {boolean} true if and only if there is a VisualEditor instance
		 * on the page
		 */
		isVisualEditorOpen: function () {
			return typeof ve !== 'undefined' && ve.instances && ve.instances.length > 0;
		},

		// TODO: Doesn't currently detect reviewing with VE
		/**
		 * Checks whether the user is previewing or reviewing changes
		 * (after clicking "Show changes")
		 *
		 * @memberof mw.guidedTour#
		 *
		 * @return {boolean} true if and only if they are reviewing
		 */
		isReviewing: function () {
			return gt.isReviewingWithWikitext();
		},

		/**
		 * Checks whether the user is previewing or reviewing wikitext changes
		 * (the latter meaning the screen after clicking "Show changes")
		 *
		 * @memberof mw.guidedTour#
		 *
		 * @return {boolean} true if and only if they are reviewing wikitext
		 */
		isReviewingWithWikitext: function () {
			return mw.config.get( 'wgAction' ) === 'submit';
		},

		/**
		 * Checks whether the user just saved an edit.
		 *
		 * You can also handle the 'postEdit' mw.hook in a
		 * mw.guidedTour.StepBuilder#transition handler.
		 *
		 * This method is not necessary if post-edit is the only
		 * criterion for the transition.
		 *
		 * @memberof mw.guidedTour#
		 *
		 * @return {boolean} true if they just saved an edit, false otherwise
		 */
		isPostEdit: function () {
			return isPostEdit;
		},

		// End transition helpers

		/**
		 * Gets step of tour from querystring
		 *
		 * @private
		 *
		 * @return {string} Step
		 */
		getStepFromQuery: function () {
			return mw.util.getParamValue( 'step' );
		},

		/**
		 * Resumes a loaded tour, specifying a tour and (optionally) a step.
		 *
		 * If no step is provided, it will first try to get a step from the URL.
		 *
		 * If that fails, it will try to resume from the cookie.
		 *
		 * Finally, it will default to step 1.
		 *
		 * @memberof mw.guidedTour#
		 *
		 * @param {string} tourName Tour name
		 * @param {number|string} [step] Step, defaulting to the cookie or first step of tour.
		 */
		resumeTour: function ( tourName, step ) {
			if ( step === undefined ) {
				step = gt.getStepFromQuery() || 0;
			}

			const userState = getUserState();
			if ( ( step === 0 ) && userState.tours[ tourName ] !== undefined ) {
				// start from user state position
				showTour( tourName, gt.makeTourId( {
					name: tourName,
					step: userState.tours[ tourName ].step,
				} ) );
			}

			if ( step === 0 ) {
				step = 1;
			}
			// start from step specified
			showTour( tourName, gt.makeTourId( {
				name: tourName,
				step: step,
			} ) );
		},

		/**
		 * Removes the tour cookie for a given guider.
		 *
		 * @private
		 *
		 * @param {Object} guider any guider from the tour
		 */
		removeTourFromUserStateByGuider: function ( guider ) {
			const tourInfo = gt.parseTourId( guider.id );
			if ( tourInfo !== null ) {
				removeTourFromUserStateByName( tourInfo.name );
			}
		},

		/**
		 * Updates a single tour in the user cookie state.  The tour must already be loaded.
		 *
		 * @private
		 *
		 * @param {Object} args keyword arguments
		 * @param {Object} args.tourInfo tour info object with name and step
		 * @param {boolean} args.wasShown true if the guider was actually just shown on the
		 *   current page, false otherwise.  Certain fields can only be initialized on a
		 *   page where it was shown.
		 */
		updateUserStateForTour: function ( args ) {
			const cookieState = getCookieState();

			const tourName = args.tourInfo.name;
			// It should be defined, except when wasShown is false.
			const tourSpec = internal.definedTours[ tourName ] || {};

			// Ensure there's a sub-object for this tour
			if ( cookieState.tours[ tourName ] === undefined ) {
				cookieState.tours[ tourName ] = {};

				cookieState.tours[ tourName ].startTime = Date.now();
			}

			if (
				args.wasShown && tourSpec.showConditionally === 'stickToFirstPage' &&
				cookieState.tours[ tourName ].firstArticleId === undefined &&
				cookieState.tours[ tourName ].firstSpecialPageName === undefined
			) {
				const articleId = mw.config.get( 'wgArticleId' );
				if ( articleId !== 0 ) {
					cookieState.tours[ tourName ].firstArticleId = articleId;
				} else {
					const pageName = mw.config.get( 'wgPageName' );
					cookieState.tours[ tourName ].firstSpecialPageName = pageName;
				}
			}

			cookieState.tours[ tourName ].step = String( args.tourInfo.step );
			const cookieValue = JSON.stringify( cookieState );
			mw.cookie.set( cookieName, cookieValue, cookieParams );
		},

		// Below are exposed for unit testing only, and should be considered
		// private
		/**
		 * Returns cookie configuration, for testing only.
		 *
		 * @private
		 *
		 * @return {Object} cookie configuration
		 */
		getCookieConfiguration: function () {
			return {
				name: cookieName,
				parameters: cookieParams,
			};
		},

		/**
		 * Determines whether to show a given tour, given the name, full cookie
		 * value, and condition specified in the tour definition.
		 *
		 * Exposed only for testing.
		 *
		 * @private
		 *
		 * @param {Object} args arguments
		 * @param {string} args.tourName name of tour
		 * @param {Object} args.userState full value of tour cookie, not null
		 * @param {string} args.pageName current full page name (wgPageName format)
		 * @param {string} args.articleId current article ID
		 * @param {string} [args.condition] showIf condition specified in tour definition, if any
		 *   See mw.guidedTour.TourBuilder#constructor for usage
		 *
		 * @return {boolean} true to show, false otherwise
		 * @throws {mw.guidedTour.TourDefinitionError} On invalid conditions
		 */
		shouldShowTour: function ( args ) {
			const subState = args.userState.tours[ args.tourName ];
			if ( args.condition !== undefined ) {
				// TODO (mattflaschen, 2013-07-09): Allow having multiple
				// conditions ANDed together in an array.
				switch ( args.condition ) {
					case 'stickToFirstPage':
						if ( subState === undefined ) {
							// Not yet shown
							return true;
						}
						if ( subState.firstArticleId !== undefined ) {
							return subState.firstArticleId === args.articleId;
						} else if ( subState.firstSpecialPageName !== undefined ) {
							return subState.firstSpecialPageName === args.pageName;
						}
						break;
					case 'wikitext':
						// Any screen that is *not* VisualEditor-specific
						// Reading, history, wikitext-specific screens, etc.
						return !gt.isVisualEditorOpen();
					case 'VisualEditor':
						// Any screen that is *not* wikitext-specific
						// Reading, history, VisualEditor screen, etc.
						return !gt.isEditingWithWikitext() && !gt.isReviewingWithWikitext();
					default:
						throw new gt.TourDefinitionError( '\'' + args.condition + '\' is not a supported condition' );
				}
			}

			// No conditions or inconsistent cookie data
			return true;
		},
	} );

	/**
	 * Creates a tour based on an object specifying it, but does not show
	 * it immediately
	 *
	 * mw.guidedTour.Tour#constructor has details on tourSpec.name,
	 * tourSpec.isSinglePage, and tourSpec.showConditionally.
	 *
	 * @method defineTour
	 * @memberof mw.guidedTour#
	 *
	 * @param {Object} tourSpec object specifying tour
	 * @param {Array} tourSpec.steps Array of steps; see
	 * mw.guidedTour.TourBuilder#step.  In addition, the following
	 * option is supported only through defineTour.
	 * @param {Function} [tourSpec.steps.shouldSkip] Function returning a
	 *  boolean, which specifies whether to skip the current step based on the
	 *  page state
	 * @param {boolean} tourSpec.steps.shouldSkip.return true to skip, false
	 *  otherwise
	 *
	 * @return {mw.guidedTour.TourBuilder} the builder used to create the tour
	 * @throws {mw.guidedTour.TourDefinitionError} On invalid input
	 */
	gt.defineTour = function ( tourSpec ) {
		const stepBuilders = [];
		let stepCount = null, steps = null;

		/**
		 * Prepares a stepSpec for being passed to firstStep or step
		 *
		 * @private
		 *
		 * @param {number} index 0-based index in step array for step to convert
		 * @param {Object} stepSpec Specification
		 *
		 * @return {Object} Augmented object
		 */
		function convertStepSpec( index, stepSpec ) {
			return $.extend( true, {
				name: ( index + 1 ).toString(),
				allowAutomaticNext: false,
			}, stepSpec );
		}

		/**
		 * Follows the chain of shouldSkip through the steps, and returns the
		 * resulting StepBuilder, mw.guidedTour.TransitionAction#hide (if the last
		 * shouldSkip returns true), or undefined
		 *
		 * @private
		 *
		 * @param {number} skipStartIndex 0-based index of the step to start at
		 * @param {number} delta +1 for moving forwards, -1 for moving backwards
		 *
		 * @return {mw.guidedTour.StepBuilder|mw.guidedTour.TransitionAction|undefined}
		 *  next step, hide (if the tour should be hidden for now), or undefined
		 *  for no change
		 */
		function followShouldSkip( skipStartIndex, delta ) {
			let skipIndex = skipStartIndex;

			while ( skipIndex >= 0 &&
				skipIndex < stepCount &&
				steps[ skipIndex ].shouldSkip &&
				steps[ skipIndex ].shouldSkip() ) {

				skipIndex += delta;
			}

			if ( skipIndex === skipStartIndex ) {
				// No change, so don't skip
				return undefined;
			} else if ( skipIndex >= 0 && skipIndex < stepCount ) {
				return stepBuilders[ skipIndex ];
			} else {
				// Skipped past the end
				return gt.TransitionAction.HIDE;
			}
		}

		/**
		 * Gets a transition callback for the given start index
		 *
		 * @private
		 *
		 * @param {number} startIndex 0-based index of step to convert
		 *
		 * @return {Function} Handler that returns the target after skipping
		 */
		function getTransitionHandler( startIndex ) {
			return function ( event ) {
				let delta = 1;
				if ( event.type === gt.TransitionEvent.BUILTIN && event.subtype === gt.TransitionEvent.TRANSITION_BACK ) {
					delta = -1;
				}
				return followShouldSkip( startIndex, delta );
			};
		}

		if ( arguments.length !== 1 ) {
			// Object itself is checked in TourBuilder.
			throw new gt.TourDefinitionError( 'Check your syntax. There must be exactly one argument, \'tourSpec\', which must be an object.' );
		}

		const tourBuilder = new gt.TourBuilder( tourSpec );

		steps = tourSpec.steps;
		if ( !Array.isArray( steps ) || steps.length < 1 ) {
			throw new gt.TourDefinitionError( '\'tourSpec.steps\' must be an array, a list of one or more steps.' );
		}

		stepCount = steps.length;

		stepBuilders[ 0 ] = tourBuilder.firstStep(
			convertStepSpec( 0, tourSpec.steps[ 0 ] )
		);

		for ( let i = 1; i < stepCount; i++ ) {
			stepBuilders[ i ] = tourBuilder.step(
				convertStepSpec( i, steps[ i ] )
			);
		}

		for ( let j = 0; j < stepCount; j++ ) {
			if ( j < stepCount - 1 ) {
				stepBuilders[ j ].next( stepBuilders[ j + 1 ] );
			}
			if ( j > 0 ) {
				stepBuilders[ j ].back( stepBuilders[ j - 1 ] );
			}

			// Don't register a custom skip handler if it can never skip.
			if ( steps[ j ].shouldSkip ) {
				stepBuilders[ j ].transition( getTransitionHandler( j ) );
			}
		}

		return tourBuilder;
	};

	/**
	 * @class mw.guidedTour.TourDefinitionError
	 * @classdesc Error subclass for errors that occur during tour definition
	 * @extends Error
	 *
	 * @constructor
	 * @param {string} message Error message text
	 */
	gt.TourDefinitionError = function ( message ) {
		this.message = message;
	};

	gt.TourDefinitionError.prototype.toString = function () {
		return 'TourDefinitionError: ' + this.message;
	};
	gt.TourDefinitionError.prototype.constructor = gt.TourDefinitionError;

	/**
	 * @class mw.guidedTour.IllegalArgumentError
	 * @classdesc Error subclass for invalid arguments (that are not part of tour definition)
	 * @extends Error
	 *
	 * @constructor
	 * @param {string} message Error message text
	 */
	gt.IllegalArgumentError = function ( message ) {
		this.message = message;
	};

	gt.IllegalArgumentError.prototype.toString = function () {
		return 'IllegalArgumentError: ' + this.message;
	};
	gt.IllegalArgumentError.prototype.constructor = gt.IllegalArgumentError;

	initialize();
}( mw.libs.guiders ) );
