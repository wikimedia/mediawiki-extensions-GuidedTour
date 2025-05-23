// Validation and canonicalization should be put here or in TourBuilder whenever possible.
( function () {
	const gt = mw.guidedTour;

	/**
	 * @class mw.guidedTour.StepBuilder
	 * @classdesc A builder for defining a step of a guided tour
	 *
	 * @constructor
	 * @description Constructs a StepBuilder
	 * @param {mw.guidedTour.Tour} tour Tour the corresponding Step belongs to
	 * @param {Object} stepSpec See {mw.guidedTour.TourBuilder#step} for details.
	 * @throws {mw.guidedTour.TourDefinitionError} On invalid step name
	 */
	function StepBuilder( tour, stepSpec ) {
		/**
		 * Tour the corresponding step belongs to
		 *
		 * @property {mw.guidedTour.Tour}
		 * @private
		 */
		this.tour = tour;

		if ( typeof stepSpec.name !== 'string' || /[.-]/.test( stepSpec.name ) ) {
			throw new gt.TourDefinitionError( '\'stepSpec.name\' must be a string, the step name, without the characters \'.\' and \'-\'.' );
		}

		if ( stepSpec.attachTo && stepSpec.position === undefined ) {
			throw new gt.TourDefinitionError( 'If you specify an \'attachTo\', you must also specify \'position\'; see TourBuilder.step' );
		}

		/**
		 * Step being built by this StepBuilder
		 *
		 * @property {mw.guidedTour.Step}
		 * @private
		 */
		this.step = new gt.Step( tour, stepSpec );
	}

	// TODO (mattflaschen, 2014-03-18): Tour-level listeners and jQuery listeners (at
	// both levels)
	/**
	 * Tell the step to listen for one or more mw.hook types
	 *
	 * @param {...string} hookNames hook names to listen for, with each as a
	 *   separate parameter
	 *
	 * @return {mw.guidedTour.StepBuilder}
	 * @chainable
	 */
	StepBuilder.prototype.listenForMwHooks = function () {
		let i;
		for ( i = 0; i < arguments.length; i++ ) {
			this.step.listenForMwHook( arguments[ i ] );
		}
		return this;
	};

	/**
	 * Canonicalizes and checks a step reference passed to the builder before
	 * it is transitioned to
	 *
	 * @private
	 *
	 * @param {string|mw.guidedTour.StepBuilder} rawStep Step to canoncialize
	 * @param {string} exceptionPrefix Prefix, used if an exception is thrown
	 * @param {string} direction The direction being transitioned in ("next"
	 * or "back"). Null when processing the result of another transition
	 *
	 * @return {mw.guidedTour.Step|null} Canonicalized step, or null if
	 * the step transitioned to nothing.
	 *
	 * @throws {mw.guidedTour.TourDefinitionError} If there is no step with this name,
	 *  or the StepBuilder is not part of the current tour
	 */
	StepBuilder.prototype.canonicalizeStep = function ( rawStep, exceptionPrefix, direction ) {
		let step;

		if ( typeof rawStep === 'string' ) {
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
		} catch ( ex ) {
			throw new gt.TourDefinitionError( exceptionPrefix + ': ' + ex.message );
		}
		if ( this.tour.emitTransitionOnStep && direction ) {
			const transitionEvent = new gt.TransitionEvent();
			transitionEvent.type = gt.TransitionEvent.BUILTIN;
			if ( direction === 'next' ) {
				transitionEvent.subtype = gt.TransitionEvent.TRANSITION_NEXT;
			} else {
				transitionEvent.subtype = gt.TransitionEvent.TRANSITION_BACK;
			}
			step = step.checkTransition( transitionEvent );
		}

		return step;
	};

	/**
	 * Tell the step how to determine the next step.
	 * Calling 'next' in the tour definition now automatically creates a next button
	 * if one isn't specified already.
	 *
	 * Invalid values or return values from the callback (a step name that does not
	 * refer to a valid step, a StepBuilder that is not part of the same tour) will
	 * cause an mw.guidedTour.TourDefinitionError exception to be thrown when the
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
	 * @return {mw.guidedTour.StepBuilder}
	 * @throws {mw.guidedTour.TourDefinitionError} If this direction callback has has already
	 *  been set
	 * @memberof mw.guidedTour.StepBuilder
	 * @method next
	 */
	StepBuilder.prototype.next = function ( nextValue ) {
		return this.setDirectionCallback( 'next', nextValue );
	};

	/**
	 * Tell the step how to determine the back step
	 * Calling 'back' in the tour definition now automatically creates a back button
	 * if one isn't specified already.
	 *
	 * Invalid values or return values from the callback (a step name that does not
	 * refer to a valid step, a StepBuilder that is not part of the same tour) will
	 * cause an mw.guidedTour.TourDefinitionError exception to be thrown when the
	 * step is requested.
	 *
	 * @param {mw.guidedTour.StepBuilder|string|Function} backValue Value used to
	 *  determine the back step.  Either:
	 *
	 *  - a mw.guidedTour.StepBuilder; the corresponding step is always back; this must
	 *   belong to the same tour
	 *  - a step name as string; the corresponding step is always back
	 *  - a Function that returns one of the above; this allows the back step to vary
	 *    dynamically
	 *
	 * @chainable
	 * @return {mw.guidedTour.StepBuilder}
	 * @throws {mw.guidedTour.TourDefinitionError} If this direction callback has has already
	 *  been set
	 * @memberof mw.guidedTour.StepBuilder
	 * @method back
	 */
	StepBuilder.prototype.back = function ( backValue ) {
		return this.setDirectionCallback( 'back', backValue );
	};

	/**
	 * Set the callback of the step direction.
	 *
	 * Invalid values or return values from the callback (a step name that does not
	 * refer to a valid step, a StepBuilder that is not part of the same tour) will
	 * cause an mw.guidedTour.TourDefinitionError exception to be thrown when the
	 * step is requested.
	 *
	 * @private
	 * @param {string} direction Name of direction. Currently 'next' and 'back' are supported.
	 * @param {mw.guidedTour.StepBuilder|string|Function} step Value used to
	 *  determine the step callback for the specified direction.  Either:
	 *
	 *  - a mw.guidedTour.StepBuilder;  this must belong to the same tour
	 *  - a step name as string;
	 *  - a Function that returns one of the above; this allows the step callback to vary
	 *    dynamically
	 *
	 * @chainable
	 * @return {mw.guidedTour.StepBuilder}
	 * @throws {mw.guidedTour.TourDefinitionError} If this direction callback has has already
	 *  been set
	 */
	StepBuilder.prototype.setDirectionCallback = function ( direction, step ) {
		const currentStep = this.step;

		if ( currentStep.hasCallback( direction ) ) {
			throw new gt.TourDefinitionError( '.' + direction + '() can not be called more than once per StepBuilder' );
		}

		let callback;
		if ( typeof step === 'function' ) {
			callback = () => {
				const directionReturn = step();
				return this.canonicalizeStep(
					directionReturn,
					'Callback passed to .' + direction + '() returned invalid value',
					direction
				);
			};
		} else {
			// This allows for forward references (passing the name of a step
			// that isn't built yet) in the tour script.  Validation is done
			// when the step change is requested.
			callback = () => this.canonicalizeStep(
				step,
				'Value passed to .' + direction + '() does not refer to a valid step',
				direction
			);
		}
		currentStep.setCallback( direction, callback );
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
	 * @return {mw.guidedTour.StepBuilder}
	 * @throws {mw.guidedTour.TourDefinitionError} If StepBuilder.transition() has already
	 *  been called, or callback is not a function
	 * @memberof mw.guidedTour.StepBuilder
	 * @method transition
	 */
	StepBuilder.prototype.transition = function ( callback ) {
		const currentStep = this.step;

		if ( currentStep.hasCallback( 'transition' ) ) {
			throw new gt.TourDefinitionError( '.transition() can not be called more than once per StepBuilder' );
		}

		// next and transition have different signatures, so try to catch some issues up front
		if ( typeof callback !== 'function' ) {
			throw new gt.TourDefinitionError( '.transition() takes one argument, a function' );
		}

		currentStep.setCallback( 'transition', ( transitionEvent ) => {
			const transitionReturn = callback( transitionEvent );

			if ( typeof transitionReturn === 'number' ) {
				if (
					transitionReturn !== gt.TransitionAction.HIDE &&
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
				return this.canonicalizeStep(
					transitionReturn,
					'Callback passed to .transition() returned invalid value',
					null
				);
			}
		} );
		return this;
	};

	mw.guidedTour.StepBuilder = StepBuilder;
}() );
