( function () {
	/**
	 * @class mw.guidedTour.TransitionEvent
	 * @alternateClassName gt.TransitionEvent
	 *
	 * Information on the event that triggered a transition check.
	 */

	/**
	 * Constructs a TransitionEvent
	 *
	 * @class
	 * @constructor
	 * @private
	 */
	function TransitionEvent() {}

	/**
	 * Type string indicating event was initiated by GuidedTour
	 *
	 * This type is in progress, and the usage may change.
	 *
	 * @property {string}
	 * @static
	 * @readonly
	 */
	TransitionEvent.BUILTIN = 'BUILTIN';

	/**
	 * Type string indicating event was initiated by mw.hook firing
	 *
	 * @property {string}
	 * @static
	 * @readonly
	 */
	TransitionEvent.MW_HOOK = 'MW_HOOK';

	/**
	 * Subtype string indicating a builtin event was fired immediately before a guider
	 * was shown
	 *
	 * @property {string}
	 * @static
	 * @readonly
	 */
	TransitionEvent.TRANSITION_BEFORE_SHOW = 'TRANSITION_BEFORE_SHOW';

	/**
	 * Subtype string indicating a builtin event was fired because the user clicked
	 * the next button
	 *
	 * @property {string}
	 * @static
	 * @readonly
	 */
	TransitionEvent.TRANSITION_NEXT = 'TRANSITION_NEXT';

	/**
	 * Subtype string indicating a builtin event was fired because the user clicked
	 * the back button
	 *
	 * @property {string}
	 * @static
	 * @readonly
	 */
	TransitionEvent.TRANSITION_BACK = 'TRANSITION_BACK';

	/**
	 * Type of event that triggered the transition check
	 *
	 * Current possible values are:
	 *
	 *  - gt.TransitionEvent.BUILTIN - builtin event
	 *  - gt.TransitionEvent.MW_HOOK - mw.hook event
	 *
	 * @property {string} type
	 */

	/**
	 * Subtype of event; currently only used for 'builtin' type.
	 *
	 * @property {string|undefined} subtype
	 */

	/**
	 * Hook name, only for 'mw.hook' type
	 *
	 * @property {string|undefined} hookName
	 */

	/**
	 * Hook arguments, only for 'mw.hook' type.  This converts the arguments (0 or more)
	 * passed when the hook fired to an array.
	 *
	 * @property {Array|undefined} hookArguments
	 * @ignore
	 */

	mw.guidedTour = mw.guidedTour || {};
	mw.guidedTour.TransitionEvent = TransitionEvent;
}() );
