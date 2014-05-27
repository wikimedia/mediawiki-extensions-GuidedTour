( function ( mw, $ ) {
	var gt = mw.guidedTour,
		guiders = mw.libs.guiders,
		skin = mw.config.get( 'skin' );

	/**
	 * @class mw.guidedTour.Step
	 *
	 * A step of a guided tour
	 *
	 * @private
	 */

	/**
	 * @method constructor
	 *
	 * Create a new step of the given tour
	 *
	 * @private
	 *
	 * @param {mw.guidedTour.Tour} tour Tour this step belongs to
	 * @param {Object} stepSpec specification of step.  See mw.guidedTour.TourBuilder#step
	 *   for details of stepSpec
	 *
	 * @throws {mw.guidedTour.TourDefinitionError} On invalid input
	 */
	function Step( tour, stepSpec ) {
		/**
		 * Tour this step belongs to
		 *
		 * @property {mw.guidedTour.Tour}
		 * @private
		 */
		this.tour = tour;

		/**
		 * Name of step; not displayed to user
		 *
		 * @property {string}
		 * @private
		 * @readonly
		 */
		this.name = stepSpec.name;

		/**
		 * Fields specifying behavior of step
		 *
		 * @property {Object}
		 * @private
		 */
		this.specification = $.extend( true, {
			// TODO (mattflaschen, 2014-04-02): onClose is not documented as
			// part of the public API.
			//
			// Consider whether to keep support for user values for them.  Either
			// document or remove support.
			onClose: $.noop,
			onShow: $.noop,
			allowAutomaticOkay: true
		}, stepSpec );

		// Required by guiders.initGuider
		this.specification.id = gt.makeTourId( {
			name: tour.name,
			step: this.name
		} );

		/**
		 * Mapping between mw.hook names and registered listeners.
		 *
		 * Key is mw.hook name, and value is listener function.  When there is no
		 * listener registered, the value for each will be null.
		 *
		 * @property {Object}
		 * @private
		 */
		this.hookListeners = {};

		/**
		 * Function called to determine the next step, if action: 'next' is used
		 *
		 * This is already canonicalized, so it can simply be called, and will
		 * always return the next {mw.guidedTour.Step}.  If there is a problem with
		 * the tour definition, it will throw an exception.
		 *
		 * @private
		 *
		 * @return {mw.guidedTour.Step} Step object for next step
		 * @throws {mw.guidedTour.TourDefinitionError} If the next step is
		 *   not set, or set to an invalid value or callback
		 */
		this.nextCallback = function () {
			throw new gt.TourDefinitionError( 'action: "next" used without calling .next() when building step' );
		};

		/**
		 * Function called to determine whether to transition the current step.  It
		 * can return a step name to go to, or a gt.TransitionAction .
		 *
		 * This is canonicalized, so it will always return either a step or a
		 * TransitionAction (for example, if the handler returns undefined, that is
		 * converted into the current step).
		 *
		 * @private
		 *
		 * @param {mw.guidedTour.TransitionEvent} transitionEvent Event that
		 *  triggered the transition check
		 *
		 * @return {mw.guidedTour.Step|mw.guidedTour.TransitionAction} Step object
		 *  or TransitionAction
		 */
		this.transitionCallback = function () {
			// With just 'return this;', jsduck auto-detects it as chainable
			// However, it's not chainable if this method is set to a custom
			// value, which it is if StepBuilder.step is called.
			var self = this;
			return self;
		};
	}

	/**
	 * Gets a Guiders button specification, using the message for the provided type
	 * (if no text is provided) and the provided callback.
	 *
	 * @private
	 *
	 * @param {string} buttonType type, currently 'next' or 'okay'
	 * @param {Function} callback Function to call if they click the button
	 * @param {HTMLElement} callback.btn Raw DOM element of the okay button
	 * @param {string} [buttonName] button text to override default.
	 *
	 * @return {Object} Guiders button specification
	 */
	function getActionButton( buttonType, callback, buttonName ) {
		var buttonKey = 'guidedtour-' + buttonType + '-button';

		if ( buttonName === undefined ) {
			buttonName = mw.message( buttonKey ).parse();
		}
		return {
			name: buttonName,
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
			button.name = mw.message( button.namemsg ).parse();
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
	 * @param {Array} buttonSpecs Button specifications as used in tour.  Elements
	 *  will be mutated.  It must be passed, but if the value is falsy it will be
	 *  treated as an empty array.
	 * @param {boolean} allowAutomaticOkay True if and only if an okay can be generated.
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
					nextButton = getActionButton( 'next', next, currentButton.name );
					break;
				case 'okay':
					if ( currentButton.onclick === undefined ) {
						throw new gt.TourDefinitionError( 'You must pass an \'onclick\' function if you use an \'okay\' action.' );
					}
					okayButton = getActionButton( 'okay', currentButton.onclick, currentButton.name );
					break;
				case 'end':
					okayButton = getActionButton( 'okay', endTour, currentButton.name );
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
					currentButton.name = mw.message( currentButton.namemsg ).parse();
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
				okayButton = getActionButton( 'okay', function () {
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
	 * Register a listener for a particular mw.hook.
	 *
	 * When called, the listener checks to see a transition is needed.
	 *
	 * @private
	 *
	 * @param {string} hookName Name of mw.hook
	 *
	 * @return {void}
	 */
	Step.prototype.registerMwHookListener = function ( hookName ) {
		// mw.hook has a feature called memory, which means that hooks that have
		// fired before we add the listener will fire immediately when it's added.
		// This is undesired here.  For example, the VisualEditor
		// 've.deactivationComplete' hook (which occurs when VE is closed) can fire
		// many times without a page reload.  However, if we want to change steps
		// when they exit the current VisualEditor session, past firings are not
		// relevant.
		var isDoneRegistration = false, listener;

		listener = $.proxy( function () {
			var transitionEvent, stepAfterTransition;

			// If it fires while we're registering it, disregard as a memory firing.
			if ( isDoneRegistration ) {
				transitionEvent = new gt.TransitionEvent();
				transitionEvent.type = gt.TransitionEvent.MW_HOOK;
				transitionEvent.hookName = hookName;
				transitionEvent.hookArguments = Array.prototype.slice.call( arguments, 0 );
				stepAfterTransition = this.checkTransition( transitionEvent );
				if ( stepAfterTransition !== null ) {
					this.tour.showStep( stepAfterTransition );
				}
			}
		}, this );

		mw.hook( hookName ).add( listener );
		isDoneRegistration = true;
		this.hookListeners[hookName] = listener;
	};

	/**
	 * Listens for a single mw.hook
	 *
	 * @private
	 *
	 * @param {string} hookName name of hook to listen for
	 *
	 * @return {void}
	 */
	Step.prototype.listenForMwHook = function ( hookName ) {
		this.hookListeners[hookName] = null;
	};

	/**
	 * Registers mw.hook listeners
	 *
	 * @private
	 *
	 * @return {void}
	 */
	Step.prototype.registerMwHooks = function () {
		var hookName;

		for ( hookName in this.hookListeners ) {
			this.registerMwHookListener( hookName );
		}
	};

	/**
	 * Unregisters mw.hook listeners
	 *
	 * @private
	 *
	 * @return {void}
	 */
	Step.prototype.unregisterMwHooks = function () {
		var hookName;
		for ( hookName in this.hookListeners ) {
			mw.hook( hookName).remove( this.hookListeners[hookName] );
			this.hookListeners[hookName] = null;
		}
	};

	/**
	 * Handles the onShow call by guiders.  May save to cookie, depending
	 * on settings (isSinglePage causes it not to modify the cookie).
	 *
	 * Registers hooks for the current step, and unregisters hooks that are no longer
	 * needed.
	 *
	 * @private
	 *
	 * @param {Object} guider Guider object provided by Guiders.js
	 *
	 * @return {void}
	 */
	Step.prototype.handleOnShow = function ( guider ) {
		var tourInfo = gt.parseTourId( guider.id ), priorCurrentStep;

		//If this is not part of a single-page tour, save the guider id to a cookie
		if ( !this.tour.isSinglePage ) {
			gt.updateUserStateForTour( {
				tourInfo: tourInfo,
				wasShown: true
			} );
		}

		priorCurrentStep = this.tour.currentStep;
		if ( priorCurrentStep !== null ) {
			priorCurrentStep.unregisterMwHooks();
		}

		this.registerMwHooks();
		this.tour.currentStep = this;
	};

	/**
	 * Provides onClose handler called by Guiders on a user-initiated close action.
	 *
	 * Hides guider.  If they clicked the 'x' button, also ends the tour, removing the
	 * cookie.
	 *
	 * Distinct from guider.onHide() because onHide is called anytime a guider is
	 * hidden.  All onClose events are directly followed by onHide, but onHide is
	 * also called whenever a guider is hidden.  This includes 'next' and when
	 * mw.guidedTour.Tour#showStep hides a guider before showing another from the same
	 * tour.
	 *
	 * @private
	 *
	 * @param {Object} guider Guider object
	 * @param {boolean} isAlternativeClose true if is not the text close button (legacy)
	 * @param {string} closeType Guider string identify close method, currently
	 *  'xButton', 'escapeKey', or 'clickOutside'
	 *
	 * @return {boolean} true to end tour, false to dismiss
	 */
	Step.prototype.handleOnClose = function ( guider, isAlternativeClose, closeType ) {
		if ( closeType === 'xButton' ) {
			gt.removeTourFromUserStateByGuider( guider );
		}
	};

	// TODO (mattflaschen, 2014-03-11): When the rendering code is no longer a separate
	// layer (guiders), eliminate the specification field.
	//
	// Instead, unpack these to direct private or readonly fields of the (step)
	// object.  At that point, the transform/validate part of this could be done in the
	// StepBuilder constructor, and there wil be no need for an initGuider call.
	// Invalid input should throw even if the tour is not shown on this page.
	/**
	 * Initializes step, making it ready to be displayed.
	 * Other methods call this after all augmentation is complete.
	 *
	 * @param {boolean} shouldFlipHorizontally true to flip requested position
	 *  horizontally before calling low-level guiders library, false otherwise
	 *
	 * @return {boolean} true
	 *
	 * @private
	 */
	Step.prototype.initialize = function ( shouldFlipHorizontally ) {
		var self = this, options = this.specification,
			passedInOnClose = options.onClose, passedInOnShow = options.onShow;

		// For passedInOnClose and passedInOnShow, 'this' is the
		// individual guider object.
		//
		// For Step.prototype.{handleOnClose,handleOnShow,unregisterMwHooks}, self
		// (the Step) is used for 'this'.
		options.onClose = function () {
			passedInOnClose.apply( this, arguments );
			return Step.prototype.handleOnClose.apply( self, arguments );
		};

		options.onShow = function () {
			// Unlike the above the order is different.  This ensures
			// handleOnShow (which does not return a value) always runs, and
			// the user-provided function (if any) can return a value.
			Step.prototype.handleOnShow.apply( self, arguments );
			return passedInOnShow.apply( this, arguments );
		};

		if ( options.titlemsg ) {
			options.title = mw.message( options.titlemsg ).parse();
		}
		delete options.titlemsg;

		if ( options.descriptionmsg ) {
			options.description = mw.message( options.descriptionmsg ).parse();
		}
		delete options.descriptionmsg;

		options.buttons = getButtons( options.buttons, options.allowAutomaticOkay );
		delete options.allowAutomaticOkay;

		options.classString = options.classString || '';
		options.classString += ' ' + this.tour.cssClass;

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

		options.next = function () {
			return self.nextCallback().specification.id;
		};

		guiders.initGuider( options );

		return true;
	};

	/**
	 * Calls the transition callback.  Handles special transition actions, then returns the next
	 * step that should be displayed, or null if no step should be displayed now.
	 *
	 * @private
	 *
	 * @param {mw.guidedTour.TransitionEvent} transitionEvent event that triggered the check
	 *
	 * @return {mw.guidedTour.Step|null} next step to display, or null if no step
	 *  should be displayed now
	 */
	Step.prototype.checkTransition = function ( transitionEvent ) {
		var transitionReturn = this.transitionCallback( transitionEvent );

		if ( $.type( transitionReturn ) === 'number' ) {
			// TransitionAction enum
			// XXX (mattflaschen, 2014-03-17): These methods affect logging, so
			// finalize that discussion, then correct this part.
			if ( transitionReturn === gt.TransitionAction.HIDE ) {
				guiders.hideAll();
			} else if ( transitionReturn === gt.TransitionAction.END ) {
				gt.endTour( this.tour.name );
			}
			return null;
		} else {
			return transitionReturn;
		}
	};

	mw.guidedTour.Step = Step;
}( mediaWiki, jQuery ) );
