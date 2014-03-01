// Validation and canonicalization should be put here or in TourBuilder whenever possible.
( function ( mw, $ ) {
	var gt = mw.guidedTour;

	/**
	 * @class mw.guidedTour.StepBuilder
	 *
	 * A builder for defining a step of a guided tour
	 */

	/**
	 * @method constructor
	 *
	 * Constructs a StepBuilder
	 *
	 * @param {mw.guidedTour.Tour} tour Tour the corresponding Step belongs to
	 * @param {Object} stepSpec See {mw.guidedTour.TourBuilder#step} for details.
	 */
	function StepBuilder( tour, stepSpec ) {
		/**
		 * Tour the corresponding step belongs to
		 *
		 * @property {mw.guidedTour.Tour}
		 * @private
		 */
		this.tour = tour;

		if ( $.type( stepSpec.name ) !== 'string' ) {
			throw new gt.TourDefinitionError( '\'stepSpec.name\' must be a string, the step name.' );
		}

		/**
		 * Step being built by this StepBuilder
		 *
		 * @property {mw.guidedTour.Step}
		 * @private
		 */
		this.step = new gt.Step( tour, stepSpec );

		/**
		 * True if and only if .next() has been called
		 *
		 * @property {boolean}
		 * @private
		 */
		this.isNextCallbackSet = false;

		/**
		 * True if and only if .transition() has been called
		 *
		 * @property {boolean}
		 * @private
		 */
		this.isTransitionCallbackSet = false;
	}

	// TODO (mattflaschen, 2014-03-18): Tour-level listeners and jQuery listeners (at
	// both levels)
	/**
	 * Tell the step to listen for one or more mw.hook types
	 *
	 * @param {string...} hookNames hook names to listen for, with each as a
	 *   separate parameter
	 * @chainable
	 */
	StepBuilder.prototype.listenForMwHooks = function () {
		var i;
		for ( i = 0; i < arguments.length; i++ ) {
			this.step.listenForMwHook( arguments[i] );
		}
		return this;
	};

	/**
	 * Canonicalizes and checks a step reference passed to the builder
	 *
	 * @private
	 *
	 * @param {string|mw.guidedTour.StepBuilder} rawStep Step to canoncialize
	 * @param {string} exceptionPrefix Prefix, used if an exception is thrown
	 *
	 * @return {mw.guidedTour.Step} Canonicalized step
	 *
	 * @throws {mw.guidedTour.TourDefinitionError} If there is no step with this name,
	 *  or the StepBuilder is not part of the current tour
	 */
	StepBuilder.prototype.canonicalizeStep = function ( rawStep, exceptionPrefix ) {
		var step;

		if ( $.type( rawStep ) === 'string' ) {
			// Step name
			step = rawStep;
		} else {
			// StepBuilder
			step = rawStep.step;
		}

		try {
			// Ensures it's a Step (could be a step name)
			// and checks for validity.
			step = this.tour.getStep( step );
		} catch( ex ) {
			throw new gt.TourDefinitionError( exceptionPrefix + ': ' + ex.message );
		}

		return step;
	};

	/**
	 * Tell the step how to determine the next step
	 *
	 * Invalid values or return values from the callback (a step name that does not
	 * refer to a valid step, a StepBuilder that is not part of the same tour) will
	 * cause an mw.guidedTour.TourDefinitionError exception to be thrown when the next
	 * step is requested.
	 *
	 * @param {mw.guidedTour.StepBuilder|string|Function} nextValue Value used to
	 *  determine the next step.  Either:
	 *
	 *  - a mw.guidedTour.StepBuilder; the corresponding step is always next; this must
	 *   belong to the same tour
	 *  - a step name as string; the corresponding step is always next
	 *  - a Function that returns one of the above; this allows the next step to vary
	 *    dynamically
	 *
	 * @chainable
	 * @throws {mw.guidedTour.TourDefinitionError} If StepBuilder.next() has already
	 *  been called
	 */
	StepBuilder.prototype.next = function ( nextValue ) {
		var stepBuilder = this;

		if ( this.isNextCallbackSet ) {
			throw new gt.TourDefinitionError( '.next() can not be called more than once per StepBuilder' );
		}

		if ( $.isFunction( nextValue ) ) {
			this.step.nextCallback = function () {
				var nextReturn = nextValue();
				return stepBuilder.canonicalizeStep(
					nextReturn,
					'Callback passed to .next() returned invalid value'
				);
			};
		} else {
			// This allow forward references (passing the name of a step that
			// isn't built yet), validation is done when the next step is
			// requested.
			this.step.nextCallback = function () {
				return stepBuilder.canonicalizeStep(
					nextValue,
					'Value passed to .next() does not refer to a valid step'
				);
			};
		}

		this.isNextCallbackSet = true;
		return this;
	};

	// TODO (mattflaschen, 2014-03-14): Extend to allow tour to transition when step does
	// nothing, and to support jQuery events (either just with DOM selectors, or also
	// with plain objects).
	/**
	 * Tell the step what to do at possible transition points, such as when hooks and events
	 * that are being listened to fire.
	 *
	 * The passed in callback is called to check whether the tour should move to a new
	 * step.  The callback can return the step to move to, as a
	 * mw.guidedTour.StepBuilder or a step name.  It may also return two special values:
	 *
	 * - gt.TransitionAction.HIDE - Hides the tour, but keeps the stored user state
	 * - gt.TransitionAction.END - Ends the tour, clearing the user state
	 *
	 * The callback may also return nothing. In that case, it will not transition.
	 *
	 * Invalid return values from the callback (a step name that does not refer to a
	 * valid step, a StepBuilder that is not part of the same tour, or a number that
	 * is not a valid TransitionAction) will cause a mw.guidedTour.TourDefinitionError
	 * exception to be thrown when the tour checks to see if it should transition.
	 *
	 * @param {Function} callback Callback called to determine whether to transition, and if
	 *  so what to do (either move to another step or do a TransitionAction)
	 * @param {mw.guidedTour.TransitionEvent} callback.transitionEvent Event that triggered the
	 *  check; see mw.guidedTour.TransitionEvent for fields
	 * @param {mw.guidedTour.StepBuilder|mw.guidedTour.TransitionAction|string} callback.return
	 *  Step to move to, as StepBuilder or step name, a mw.guidedTour.TransitionAction for a
	 *  special action, or falsy for no requested transition (see above).
	 *
	 * @chainable
	 * @throws {mw.guidedTour.TourDefinitionError} If StepBuilder.transition() has already
	 *  been called, or callback is not a function
	 */
	StepBuilder.prototype.transition = function ( callback ) {
		var stepBuilder = this, currentStep = this.step;

		if ( this.isTransitionCallbackSet ) {
			throw new gt.TourDefinitionError( '.transition() can not be called more than once per StepBuilder' );
		}

		// next and transition have different signatures, so try to catch some issues up front
		if ( !$.isFunction( callback ) ) {
			throw new gt.TourDefinitionError( '.transition() takes one argument, a function' );
		}

		currentStep.transitionCallback = function ( transitionEvent ) {
			var transitionReturn = callback( transitionEvent );

			if ( $.type( transitionReturn ) === 'number' ) {
				if ( transitionReturn !== gt.TransitionAction.HIDE &&
				     transitionReturn !== gt.TransitionAction.END
				) {
					throw new gt.TourDefinitionError( 'Callback passed to .transition() returned a number that is not a valid TransitionAction' );
				}
				return transitionReturn;
			} else if ( !transitionReturn ) {
				// Mainly intended for not doing anything (implicitly
				// returning undefined), which means 'don't transition'.
				// Same behavior for any falsy value.
				return currentStep;
			} else {
				return stepBuilder.canonicalizeStep(
					transitionReturn,
					'Callback passed to .transition() returned invalid value'
				);
			}
		};

		this.isTransitionCallbackSet = true;
		return this;
	};


	mw.guidedTour.StepBuilder = StepBuilder;
}( mediaWiki, jQuery ) );
