( function ( mw, $ ) {
	var gt = mw.guidedTour,
		internal = gt.internal,
		guiders = mw.libs.guiders;

	// Any public member used to define the tour belongs in TourBuilder or
	// StepBuilder.
	/**
	 * @class mw.guidedTour.Tour
	 *
	 * @private
	 *
	 * A guided tour
	 */

	/**
	 * @method constructor
	 *
	 * @private
	 *
	 * See mw.guidedTour.TourBuilder#constructor, which passes through to this.
	 */
        function Tour ( tourSpec ) {
		var moduleName;

		/**
		 * Name of tour
		 *
		 * @property {string}
		 * @private
		 * @readonly
		 */
		this.name = tourSpec.name;

		/**
		 * Whether tour is limited to one page
		 *
		 * @property {boolean}
		 * @private
		 * @readonly
		 */
		this.isSinglePage = tourSpec.isSinglePage;

		/**
		 * Condition for showing the tour.
		 *
		 * See mw.guidedTour.Tour#constructor for details on possible values.
		 *
		 * @property {string}
		 * @private
		 * @readonly
		 */
		this.showConditionally = tourSpec.showConditionally;

		/**
		 * Whether to log events for the tour
		 *
		 * @property {boolean}
		 * @private
		 * @readonly
		 */
		this.shouldLog = tourSpec.shouldLog;

		internal.definedTours[this.name] = this;

		/**
		 * Object mapping step names to mw.guidedTour.Step objects
		 *
		 * @property {Object}
		 * @private
		 */
		this.steps = {};

		/**
		 * First step of tour
		 *
		 * @property {mw.guidedTour.Step}
		 * @private
		 */
		this.firstStep = null;

		// TODO (mattflaschen, 2014-04-04): Consider refactoring this in
		// conjunction with the user state work.
		/**
		 * Current step
		 *
		 * This step is the most recently displayed for the user.  It is not
		 * necessarily currently displayed.  It indicates the user's progress
		 * through the tour.  It corresponds to the step saved to the user's
		 * state (cookie), except for single-page tours (which use this, but not
		 * the cookie).
		 *
		 * @property {mw.guidedTour.Step}
		 * @private
		 */
		this.currentStep = null;

		// Manually updated by the TourBuilder since JavaScript does not have a
		// performant way to get the length of an object/associative array.
		/**
		 * Step count
		 *
		 * @property {number}
		 * @private
		 * @readonly
		 */
		this.stepCount = 0;

		/**
		 * CSS class
		 *
		 * @property {string}
		 * @private
		 * @readonly
		 */
		this.cssClass = 'mw-guidedtour-tour-' + this.name;

		moduleName = internal.getTourModuleName( this.name );

		/**
		 * Whether this is defined through a ResourceLoader module in an extension
		 *
		 * @property {boolean}
		 * @private
		 * @readonly
		 */
		this.isExtensionDefined = ( mw.loader.getState( moduleName ) !== null );

		/**
		 * Whether this tour has been initialized (guiders have been created)
		 *
		 * @property {boolean}
		 * @private
		 */
		this.isInitialized = false;
	}

	/**
	 * Determines whether guiders in this tour should be horizontally flipped due to LTR/RTL
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
	Tour.prototype.getShouldFlipHorizontally = function () {
		var tourDirection, interfaceDirection, siteDirection, $body;

		$body = $( document.body );

		// Main direction of the site
		siteDirection = $body.is( '.sitedir-ltr' ) ? 'ltr' : 'rtl';

		// Direction the interface is being viewed in.
		// This can be changed by user preferences or uselang
		interfaceDirection = $( 'html' ).attr( 'dir' );

		// Direction the tour is assumed to be written for
		tourDirection = this.isExtensionDefined ? 'ltr' : siteDirection;

		// We flip if needed to match the interface direction
		return tourDirection !== interfaceDirection;
	};

	/**
	 * Initializes a tour to prepare for showing it.  If it's already initialized,
	 * do nothing.
	 *
	 * @private
	 *
	 * @return {void}
	 */
	Tour.prototype.initialize = function () {
		var stepName, shouldFlipHorizontally;

		if ( this.isInitialized ) {
			return;
		}

		shouldFlipHorizontally = this.getShouldFlipHorizontally();

		for ( stepName in this.steps ) {
			this.steps[stepName].initialize( shouldFlipHorizontally );
		}

		this.isInitialized = true;
	};

	/**
	 * Checks whether any of the guiders in this tour are visible
	 *
	 * @private
	 *
	 * @return {boolean} Whether part of this tour is visible
	 */
	Tour.prototype.isVisible = function () {
		var tourVisibleSelector = '.' + this.cssClass + ':visible';

		return $( tourVisibleSelector ).length > 0;
	};

	/**
	 * Gets a step object, given a step name or step object.
	 *
	 * In either case, it checks that the step belongs to the tour, and throws an
	 * exception if it does not.
	 *
	 * @private
	 *
	 * @param {string|mw.guidedTour.Step} step Step name or step
	 *
	 * @return {mw.guidedTour.Step} step, validated to exist in this tour
	 * @throws {mw.guidedTour.IllegalArgumentError} If the step, or step name, is not
	 *   part of this tour
	 */
	Tour.prototype.getStep = function ( step ) {
		var stepName;

		if ( $.type( step ) === 'string' ) {
			stepName = step;
			step = this.steps[stepName];
			if ( !step ) {
				throw new gt.IllegalArgumentError( 'Step "' + stepName + '" not found in the "' + this.name + '" tour.' );
			}
		} else {
			if ( step.tour !== this ) {
				throw new gt.IllegalArgumentError( 'Step object must belong to this tour ("' + this.name + '")' );
			}
		}

		return step;
	};

	/**
	 * Shows a step
	 *
	 * It can be requested by name (string) or by Step (mw.guidedTour.Step).
	 *
	 * It will first check to see if the tour should transition.
	 *
	 * @private
	 *
	 * @param {mw.guidedTour.Step|string} step Step name or object
	 *
	 * @return {void}
	 */
	Tour.prototype.showStep = function ( step ) {
		var guider, transitionEvent;

		this.initialize();

		step = this.getStep( step );

		transitionEvent = new gt.TransitionEvent();
		transitionEvent.type = gt.TransitionEvent.BUILTIN;
		transitionEvent.subtype = gt.TransitionEvent.TRANSITION_BEFORE_SHOW;
		step = step.checkTransition( transitionEvent );

		// null means a TransitionAction (hide/end)
		if ( step !== null ) {
			guider = guiders._guiderById( step.specification.id );
			if ( guider !== undefined && guider.elem.is( ':visible' ) ) {
				// Already showing the same one
				return;
			}

			// A guider from the same tour is visible
			if ( this.isVisible() ) {
				guiders.hideAll();
			}

			guiders.show( step.specification.id );
		}
	};

	/**
	 * Starts tour by showing the first step
	 *
	 * @private
	 *
	 * @return {void}
	 * @throws {mw.guidedTour.TourDefinitionError} If firstStep was never called on the
	 *  TourBuilder
	 */
	Tour.prototype.start = function () {
		if ( this.firstStep === null ) {
			throw new gt.TourDefinitionError(
				'The .firstStep() method must be called for all tours.'
			);
		}

		this.showStep( this.firstStep );
	};

	mw.guidedTour.Tour = Tour;
}( mediaWiki, jQuery ) );
