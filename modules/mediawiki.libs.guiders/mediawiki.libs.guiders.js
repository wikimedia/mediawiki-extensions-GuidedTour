// TODO (mattflaschen, 2013-07-30): Remove these after the following are resolved:
// * Script URL, we need to determine the replacement, either a wrapper of the onclick that
// calls preventDefault, or another element with no default.
/*!
 * guiders.js
 *
 * Developed by Jeff Pickhardt (jeff+pickhardt@optimizely.com) at Optimizely. (www.optimizely.com)
 * We make A/B testing you'll actually use.
 *
 * Released under the Apache License 2.0.
 * www.apache.org/licenses/LICENSE-2.0.html
 *
 * Questions about Optimizely should be sent to:
 * sales@optimizely.com or support@optimizely.com
 *
 * Further developed by the Growth Team at Wikimedia.
 *
 * Enjoy!
 *
 * Changes:
 *
 * - initGuider(): Allows for initializing Guiders without actually creating them (useful when guider is not in the DOM yet. Avoids error: base is null [Break On This Error] var top = base.top;
 *
 * - overlay "error": If not set to true, this defines the class of the overlay. (This is useful for coloring the background of the overlay red on error.
 * - onShow: If this returns a guider object, then it can shunt (skip) the rest of show()
 *
 * See https://www.mediawiki.org/wiki/Extension:GuidedTour and https://phabricator.wikimedia.org/diffusion/EGTO/
 *
 * Previously, there was a MediaWiki-specific repository for
 * Guiders (based on the upstream one).  For earlier version control history, see
 * https://phabricator.wikimedia.org/diffusion/EGTG/history/
 */

/**
 * @classdesc Code for rendering and low-level code of moving between steps.
 *
 * You should use the public mw.guidedTour API when possible, rather then calling methods
 * from this file directly.  The API of this file will change.
 *
 * @author jeff+pickhardt@optimizely.com
 * @author mflaschen@wikimedia.org
 * @author tychay@php.net
 *
 * @class mw.libs.guiders
 * @singleton
 */
mw.libs.guiders = ( function () {
	const guiders = {};

	guiders._defaultSettings = {
		attachTo: null, // Selector of the element to attach to.
		autoFocus: false, // Determines whether or not the browser scrolls to the element.
		buttons: [],
		buttonCustomHTML: '',
		classString: null,
		closeOnEscape: false,
		closeOnClickOutside: false,
		description: '',
		// If guider would go off screen to the left or right, flip horizontally.
		// If guider would go off the top of the screen, flip vertically. If it would go off the bottom of the screen do nothing, since most pages scroll in the vertical direction.
		// It will be flipped both ways if it would be off-screen on two sides.
		flipToKeepOnScreen: false,
		offset: {
			top: null,
			left: null
		},
		// Function taking three arguments, the guider, a legacy boolean for close
		// type (false for text close button, true for everything else), and a text
		// string for closeMethod ('xButton', 'escapeKey', 'clickOutside')
		onClose: null,
		onHide: null,
		onShow: null,
		overlay: false,

		// 1-12 follows an analog clock, 0 means centered. You can also use the string positions
		// listed below at guiders._offsetNameMapping, such as "topRight".
		position: 0,
		title: '',
		width: 400,
		xButton: false // this places a closer "x" button in the top right of the guider
	};

	guiders._htmlSkeleton = [
		'<div class="guider">',
		'  <div class="guider_content">',
		'    <h1 class="guider_title"></h1>',
		'    <div class="guider_close"></div>',
		'    <p class="guider_description"></p>',
		'    <div class="guider_buttons"></div>',
		'  </div>',
		'  <div class="guider_arrow">',
		'    <div class="guider_arrow_inner_container">',
		'      <div class="guider_arrow_inner"></div>',
		'    </div>',
		'  </div>',
		'</div>'
	].join( '' );

	guiders._arrowSize = 42; // This is the arrow's width and height.
	guiders._buttonElement = '<button></button>';
	// eslint-disable-next-line no-script-url
	guiders._buttonAttributes = { href: 'javascript:void(0);' };
	guiders._buttonClass = 'cdx-button';
	guiders._currentGuiderID = null;
	guiders._guiderInits = {}; // stores uncreated guiders indexed by id
	guiders._guiders = {}; // stores created guiders indexed by id
	guiders._lastCreatedGuiderID = null;
	guiders._scrollDuration = 750; // In milliseconds

	// See position above in guiders._defaultSettings
	guiders._offsetNameMapping = {
		topLeft: 11,
		top: 12,
		topRight: 1,
		rightTop: 2,
		right: 3,
		rightBottom: 4,
		bottomRight: 5,
		bottom: 6,
		bottomLeft: 7,
		leftBottom: 8,
		left: 9,
		leftTop: 10
	};
	guiders._windowHeight = 0;

	// Handles a user-initiated close action (e.g. clicking close or hitting ESC)
	// isAlternativeClose is false for the text Close button, and true for everything else.
	guiders.handleOnClose = function ( myGuider, isAlternativeClose, closeMethod ) {
		if ( myGuider.onClose ) {
			myGuider.onClose( myGuider, isAlternativeClose, closeMethod );
		}

		guiders.hideAll();
	};

	guiders._makeButtonListener = function ( onclickCallback ) {
		return function ( evt ) {
			evt.preventDefault();
			onclickCallback.call( this, evt );
		};
	};

	guiders._addButtons = function ( myGuider ) {
		// Add buttons
		const guiderButtonsContainer = myGuider.elem.find( '.guider_buttons' );

		if ( myGuider.buttons === null || myGuider.buttons.length === 0 ) {
			guiderButtonsContainer.remove();
			return;
		}

		for ( let i = myGuider.buttons.length - 1; i >= 0; i-- ) {
			const thisButton = myGuider.buttons[ i ];
			let thisButtonHtml;
			if ( thisButton.hasIcon ) {
				// eslint-disable-next-line no-jquery/variable-pattern
				thisButtonHtml = $( '<span>' )
					.addClass( 'guider_button_icon' )
					.attr( 'aria-label', thisButton.name );
			} else {
				thisButtonHtml = thisButton.name;
			}
			const $thisButtonElem = $(
				thisButton.buttonElement || guiders._buttonElement,
				Object.assign(
					{
						class: guiders._buttonClass,
						html: thisButtonHtml
					},
					guiders._buttonAttributes,
					thisButton.html || {}
				)
			);

			if ( typeof thisButton.classString !== 'undefined' && thisButton.classString !== null ) {
				// eslint-disable-next-line mediawiki/class-doc
				$thisButtonElem.addClass( thisButton.classString );
			}

			guiderButtonsContainer.append( $thisButtonElem );

			if ( thisButton.onclick ) {
				$thisButtonElem.on( 'click', guiders._makeButtonListener( thisButton.onclick ) );
			}
		}

		if ( myGuider.buttonCustomHTML !== '' ) {
			const $myCustomHTML = $( myGuider.buttonCustomHTML );
			myGuider.elem.find( '.guider_buttons' ).append( $myCustomHTML );
		}

		if ( myGuider.buttons.length === 0 ) {
			guiderButtonsContainer.remove();
		}
	};

	guiders._addXButton = function ( myGuider ) {
		const xButtonContainer = myGuider.elem.find( '.guider_close' );
		let $xButton = $( '<button>' ).attr( {
			class: 'cdx-button cdx-button--icon-only cdx-button--weight-quiet',
			'aria-label': mw.msg( 'guidedtour-close-button' )
		} );
		$xButton = $xButton.append( $( '<span>' ).attr( { class: 'cdx-button__icon x_button__icon' } ) );
		xButtonContainer.append( $xButton );
		$xButton.on( {
			click: function () {
				guiders.handleOnClose( myGuider, true, 'xButton' );
			}
		} );
	};

	guiders._wireEscape = function ( myGuider ) {
		$( document ).on( 'keydown', ( event ) => {
			if ( event.keyCode === 27 || event.which === 27 ) {
				guiders.handleOnClose( myGuider, true, 'escapeKey' /* close by escape key */ );
				return false;
			}
		} );
	};

	// myGuider is passed though it's not currently used.
	guiders._unWireEscape = function ( /* myGuider */ ) {
		$( document ).off( 'keydown' );
	};

	guiders._wireClickOutside = function ( myGuider ) {
		$( document ).on( 'click.guiders', ( event ) => {
			if ( $( event.target ).closest( '.guider' ).length === 0 ) {
				guiders.handleOnClose( myGuider, true, 'clickOutside' /* close by clicking outside */ );
				if ( event.target.id === 'guider_overlay' ) {
					return false;
				}
			}
		} );
	};

	guiders._unWireClickOutside = function () {
		$( document ).off( 'click.guiders' );
	};

	/**
	 * Flips a position horizontally, vertically, both, or not all.  This can be used
	 * for various scenarios, such as handling right-to-left languages and flipping a position
	 * if the original one would go off screen.
	 *
	 * It accepts both string (e.g. "top") and numeric (e.g. 12) positions.
	 *
	 * @memberof mw.libs.guiders#
	 * @method getFlippedPosition
	 * @param {string|number} position position as in guider settings object
	 * @param {Object} options how to flip
	 * @param {boolean} options.vertical true to flip vertical (optional, defaults false)
	 * @param {boolean} options.horizontal true to flip vertical (optional, defaults false)
	 * @return {number} position with requested flippings in numeric form
	 */
	guiders.getFlippedPosition = function ( position, options ) {
		const TOP_CLOCK = 12, HALF_CLOCK = 6;

		if ( !options.horizontal && !options.vertical ) {
			return position;
		}

		// Convert to numeric if needed
		if ( guiders._offsetNameMapping[ position ] !== undefined ) {
			position = guiders._offsetNameMapping[ position ];
		}

		position = Number( position );

		if ( position === 0 ) {
			// Don't change center position.
			return position;
		}

		// This math is all based on the analog clock model used for guiders positioning.
		if ( options.horizontal && !options.vertical ) {
			position = TOP_CLOCK - position;
		} else if ( options.vertical && !options.horizontal ) {
			position = HALF_CLOCK - position;
		} else if ( options.vertical && options.horizontal ) {
			position = position + HALF_CLOCK;
		}

		if ( position < 1 ) {
			position += TOP_CLOCK;
		} else if ( position > TOP_CLOCK ) {
			position -= TOP_CLOCK;
		}

		return position;
	};

	/**
	 * Returns CSS for attaching a guider to its associated element
	 *
	 * @memberof mw.libs.guiders#
	 * @method _getAttachCss
	 * @param {jQuery} attachTo element to attach to
	 * @param {Object} guider guider object
	 * @param {number} position position for guider, using clock
	 *   model (0-12).
	 * @return {Object} CSS properties for the attachment
	 */
	guiders._getAttachCss = function ( attachTo, guider, position ) {
		const myHeight = guider.elem.innerHeight();
		const myWidth = guider.elem.innerWidth();

		if ( position === 0 ) {
			// The guider is positioned in the center of the screen.
			return {
				position: 'fixed',
				top: ( $( window ).height() - myHeight ) / 3 + 'px',
				left: ( $( window ).width() - myWidth ) / 2 + 'px'
			};
		}

		// Otherwise, the guider is positioned relative to the attachTo element.
		const base = attachTo.offset();
		let top = base.top;
		let left = base.left;

		// topMarginOfBody corrects positioning if body has a top margin set on it.
		const topMarginOfBody = $( 'body' ).outerHeight( true ) - $( 'body' ).outerHeight( false );
		top -= topMarginOfBody;

		const attachToHeight = attachTo.innerHeight();
		const attachToWidth = attachTo.innerWidth();

		const bufferOffset = 0.9 * guiders._arrowSize - 10;

		// offsetMap follows the form: [height, width]
		const offsetMap = {
			1: [ -bufferOffset - myHeight, attachToWidth - myWidth ],
			2: [ 0, bufferOffset + attachToWidth ],
			3: [ attachToHeight / 2 - myHeight / 2, bufferOffset + attachToWidth ],
			4: [ attachToHeight - myHeight, bufferOffset + attachToWidth ],
			5: [ bufferOffset + attachToHeight, attachToWidth - myWidth ],
			6: [ bufferOffset + attachToHeight, attachToWidth / 2 - myWidth / 2 ],
			7: [ bufferOffset + attachToHeight, 0 ],
			8: [ attachToHeight - myHeight, -myWidth - bufferOffset ],
			9: [ attachToHeight / 2 - myHeight / 2, -myWidth - bufferOffset ],
			10: [ 0, -myWidth - bufferOffset ],
			11: [ -bufferOffset - myHeight, 0 ],
			12: [ -bufferOffset - myHeight, attachToWidth / 2 - myWidth / 2 ]
		};
		const offset = offsetMap[ position ];
		top += offset[ 0 ];
		left += offset[ 1 ];

		let positionType = 'absolute';
		// If the element you are attaching to is position: fixed, then we will make the guider
		// position: fixed as well.
		if ( attachTo.css( 'position' ) === 'fixed' ) {
			positionType = 'fixed';
			top -= $( window ).scrollTop();
			left -= $( window ).scrollLeft();
		}

		// If you specify an additional offset parameter when you create the guider, it gets added here.
		if ( guider.offset.top !== null ) {
			top += guider.offset.top;
		}
		if ( guider.offset.left !== null ) {
			left += guider.offset.left;
		}

		return {
			position: positionType,
			top: parseInt( top, 10 ),
			left: parseInt( left, 10 )
		};
	};

	/**
	 * Gets element to attach to, wrapped by jQuery.  Filters out elements that are not
	 * :visible, such as (such as those with display: none).
	 *
	 * @private
	 *
	 * @param {Object} guider guider being attached
	 *
	 * @return {jQuery|null} jQuery node for element, or null for no match
	 */
	guiders._getAttachTarget = function ( guider ) {
		const $node = $( guider.attachTo ).filter( ':visible:first' );

		return $node.length > 0 ? $node : null;
	};

	/**
	 * Attaches a guider
	 *
	 * @memberof mw.libs.guiders#
	 * @method _attach
	 * @param {Object} myGuider guider to attach
	 * @return {jQuery|undefined} jQuery node for guider's element if successful,
	 *   or undefined for invalid input.
	 */
	guiders._attach = function ( myGuider ) {
		if ( typeof myGuider !== 'object' ) {
			return;
		}

		const $attachTarget = guiders._getAttachTarget( myGuider );

		// We keep a local position, separate from the originally requested one.
		// We alter this locally for auto-flip and missing elements.
		//
		// However, the DOM or window size may change later, and on each attach we want to start
		// with the originally requested position as the baseline.
		let position = $attachTarget !== null ? myGuider.position : 0;

		let css = guiders._getAttachCss( $attachTarget, myGuider, position );

		if ( myGuider.flipToKeepOnScreen ) {
			const rightOfGuider = css.left + myGuider.width;
			const flipVertically = css.top < 0;
			const flipHorizontally = css.left < 0 || rightOfGuider > $( 'body' ).innerWidth();
			if ( flipVertically || flipHorizontally ) {
				position = guiders.getFlippedPosition( position, {
					vertical: flipVertically,
					horizontal: flipHorizontally
				} );
				css = guiders._getAttachCss( $attachTarget, myGuider, position );
			}
		}

		guiders._styleArrow( myGuider, position );
		guiders._setupAnimations( myGuider, position );
		return myGuider.elem.css( css );
	};

	/**
	 * Gets action button element, wrapped by jQuery.  Filters out elements that are not
	 * :visible, such as (such as those with display: none).
	 *
	 * @private
	 *
	 * @param {Object} guider guider being attached
	 *
	 * @return {jQuery|null} jQuery node for element, or null for no match
	 */
	guiders._getActionBtnTarget = function ( guider ) {
		const $node = $( guider.actionBtn ).filter( ':visible:first' );

		return $node.length > 0 ? $node : null;
	};

	/**
	 * Returns the guider by ID.
	 *
	 * Add check to create and grab guider from inits if it exists there.
	 *
	 * @memberof mw.libs.guiders#
	 * @method _guiderById
	 * @param {string} id id of guider
	 * @return {Object} guider object
	 */
	guiders._guiderById = function ( id ) {
		let myGuider;

		if ( typeof guiders._guiders[ id ] === 'undefined' ) {
			if ( typeof guiders._guiderInits[ id ] === 'undefined' ) {
				throw new Error( 'Cannot find guider with id ' + id );
			}
			myGuider = guiders._guiderInits[ id ];
			guiders.createGuider( myGuider );
			delete guiders._guiderInits[ id ]; // prevents recursion
			// fall through ...
		}
		return guiders._guiders[ id ];
	};

	guiders._showOverlay = function ( overlayClass ) {
		// FIXME: Use CSS transition
		// eslint-disable-next-line no-jquery/no-fade
		$( '#guider_overlay' ).fadeIn( 'fast' ).each( function () {
			if ( overlayClass ) {
				// eslint-disable-next-line mediawiki/class-doc
				$( this ).addClass( overlayClass );
			}
		} );
	};

	guiders._hideOverlay = function () {
		// FIXME: Use CSS transition
		// eslint-disable-next-line no-jquery/no-fade
		$( '#guider_overlay' ).fadeOut( 'fast' ).removeClass();
	};

	guiders._initializeOverlay = function () {
		if ( $( '#guider_overlay' ).length === 0 ) {
			// FIXME: Stop needing this to have an ID alongside the class.
			// eslint-disable-next-line no-jquery/no-parse-html-literal
			$( '<div id="guider_overlay">' ).addClass( 'guider_overlay' ).hide().appendTo( 'body' );
		}
	};

	guiders._styleArrow = function ( myGuider, position ) {
		const $myGuiderArrow = $( myGuider.elem.find( '.guider_arrow' ) );

		position = position || 0;

		// Remove possible old direction.
		// Position, and thus arrow, can change on resize due to flipToKeepOnScreen
		// Also, if an element is added to or removed from the DOM, the arrow may need to change on reposition.
		//
		// If there should be an arrow, the new one will be added below.
		$myGuiderArrow.removeClass( 'guider_arrow_down guider_arrow_left guider_arrow_up guider_arrow_right' );

		// No arrow for center position
		if ( position === 0 ) {
			return;
		}
		const newClass = {
			1: 'guider_arrow_down',
			2: 'guider_arrow_left',
			3: 'guider_arrow_left',
			4: 'guider_arrow_left',
			5: 'guider_arrow_up',
			6: 'guider_arrow_up',
			7: 'guider_arrow_up',
			8: 'guider_arrow_right',
			9: 'guider_arrow_right',
			10: 'guider_arrow_right',
			11: 'guider_arrow_down',
			12: 'guider_arrow_down'
		};

		// Classes documented above
		// eslint-disable-next-line mediawiki/class-doc
		$myGuiderArrow.addClass( newClass[ position ] );

		const myHeight = myGuider.elem.innerHeight();
		const myWidth = myGuider.elem.innerWidth();
		const arrowOffset = guiders._arrowSize / 2;
		const positionMap = {
			1: [ 'right', arrowOffset ],
			2: [ 'top', arrowOffset ],
			3: [ 'top', myHeight / 2 - arrowOffset ],
			4: [ 'bottom', arrowOffset ],
			5: [ 'right', arrowOffset ],
			6: [ 'left', myWidth / 2 - arrowOffset ],
			7: [ 'left', arrowOffset ],
			8: [ 'bottom', arrowOffset ],
			9: [ 'top', myHeight / 2 - arrowOffset ],
			10: [ 'top', arrowOffset ],
			11: [ 'left', arrowOffset ],
			12: [ 'left', myWidth / 2 - arrowOffset ]
		};
		const arrowPosition = positionMap[ position ];
		$myGuiderArrow.css( arrowPosition[ 0 ], arrowPosition[ 1 ] + 'px' );
	};

	/**
	 * Remove all animation classes
	 *
	 * @memberof mw.libs.guiders#
	 * @method _removeAnimations
	 * @param {Object} myGuider guider to remove animations from
	 */
	guiders._removeAnimations = function ( myGuider ) {
		myGuider.elem.removeClass( 'mwe-gt-fade-in-down mwe-gt-fade-in-up mwe-gt-fade-in-left mwe-gt-fade-in-right' );
	};

	/**
	 * Add appropriate animation class relative to guider position
	 *
	 * @memberof mw.libs.guiders#
	 * @method _setupAnimations
	 * @param {Object} myGuider guider to add animation class to
	 * @param {number} position guider attachment position
	 */
	guiders._setupAnimations = function ( myGuider, position ) {
		const classMap = {
			1: 'mwe-gt-fade-in-down',
			2: 'mwe-gt-fade-in-left',
			3: 'mwe-gt-fade-in-left',
			4: 'mwe-gt-fade-in-left',
			5: 'mwe-gt-fade-in-up',
			6: 'mwe-gt-fade-in-up',
			7: 'mwe-gt-fade-in-up',
			8: 'mwe-gt-fade-in-right',
			9: 'mwe-gt-fade-in-right',
			10: 'mwe-gt-fade-in-right',
			11: 'mwe-gt-fade-in-down',
			12: 'mwe-gt-fade-in-down'
		};
		guiders._removeAnimations( myGuider );
		// Assign animation class for myGuider
		if ( position !== 0 ) {
			// Classes documented above
			// eslint-disable-next-line mediawiki/class-doc
			myGuider.elem.addClass( classMap[ position ] );
		}
	};

	guiders.reposition = function () {
		const currentGuider = guiders._guiders[ guiders._currentGuiderID ];
		guiders._attach( currentGuider );
	};

	/**
	 * Shows the 'next' step
	 *
	 * @memberof mw.libs.guiders#
	 * @method next
	 */
	guiders.next = function () {
		guiders.doStep( 'next' );
	};

	/**
	 * Shows the 'back' step
	 *
	 * @memberof mw.libs.guiders#
	 * @method back
	 */
	guiders.back = function () {
		guiders.doStep( 'back' );
	};

	/**
	 * Move the guider directionally to the corresponding step. eg. next, back
	 *
	 * @memberof mw.libs.guiders#
	 * @method doStep
	 * @param {string} direction next or back
	 */
	guiders.doStep = function ( direction ) {
		let currentGuider, moveToGuiderId, myGuider, omitHidingOverlay, actionBtn;
		try {
			currentGuider = guiders._guiderById( guiders._currentGuiderID ); // has check to make sure guider is initialized
		} catch ( err ) {
			return;
		}
		currentGuider.elem.data( 'locked', true );

		if ( currentGuider[ direction ] ) {
			moveToGuiderId = currentGuider[ direction ]();
		}
		moveToGuiderId = moveToGuiderId || null;

		if ( moveToGuiderId !== null && moveToGuiderId !== '' ) {
			myGuider = guiders._guiderById( moveToGuiderId );
			omitHidingOverlay = !!myGuider.overlay;
			guiders.hideAll( omitHidingOverlay, true );
			actionBtn = guiders._getActionBtnTarget( currentGuider );
			if ( actionBtn !== null && actionBtn !== '' ) {
				actionBtn.click();
			}
			guiders.show( moveToGuiderId );
		}
	};

	/**
	 * This stores the guider but does no work on it.
	 * It is an alternative to createGuider() that defers the actual setup work.
	 *
	 * @memberof mw.libs.guiders#
	 * @method initGuider
	 * @param {Object} passedSettings Settings
	 */
	guiders.initGuider = function ( passedSettings ) {
		if ( passedSettings === null || passedSettings === undefined ) {
			return;
		}
		if ( !passedSettings.id ) {
			return;
		}
		this._guiderInits[ passedSettings.id ] = passedSettings;
	};

	/**
	 * Creates a guider
	 *
	 * @memberof mw.libs.guiders#
	 * @method createGuider
	 * @param {Object} passedSettings settings for the guider
	 * @return {Object} guiders singleton
	 */
	guiders.createGuider = function ( passedSettings ) {
		if ( passedSettings === null || passedSettings === undefined ) {
			passedSettings = {};
		}

		// Extend those settings with passedSettings
		const myGuider = Object.assign( {}, guiders._defaultSettings, passedSettings );
		myGuider.id = myGuider.id || String( Math.floor( Math.random() * 1000 ) );

		const $guiderElement = $( guiders._htmlSkeleton );
		// eslint-disable-next-line no-jquery/variable-pattern
		myGuider.elem = $guiderElement;
		if ( typeof myGuider.classString !== 'undefined' && myGuider.classString !== null ) {
			// eslint-disable-next-line mediawiki/class-doc
			myGuider.elem.addClass( myGuider.classString );
		}
		myGuider.elem.css( 'width', myGuider.width + 'px' );

		const $guiderTitleContainer = $guiderElement.find( '.guider_title' );
		$guiderTitleContainer.html( myGuider.title );

		$guiderElement.find( '.guider_description' ).html( myGuider.description );

		guiders._addButtons( myGuider );

		if ( myGuider.xButton ) {
			guiders._addXButton( myGuider );
		}

		$guiderElement.hide();
		$guiderElement.appendTo( 'body' );
		$guiderElement.attr( 'id', myGuider.id );

		// If a string form (e.g. 'top') was passed, convert it to numeric (e.g. 12)
		// As an alternative to the clock model, you can also use keywords to position the myGuider.
		if ( guiders._offsetNameMapping[ myGuider.position ] ) {
			myGuider.position = guiders._offsetNameMapping[ myGuider.position ];
		}

		guiders._initializeOverlay();

		guiders._guiders[ myGuider.id ] = myGuider;
		guiders._lastCreatedGuiderID = myGuider.id;

		return guiders;
	};

	/**
	 * Hides all guiders
	 *
	 * @memberof mw.libs.guiders#
	 * @method hideAll
	 * @param {boolean|undefined} omitHidingOverlay falsy to hide overlay,
	 *   true not to change it
	 * @param {boolean} next true if caller will immediately show another guider
	 *   in place of the one being hidden (optional, defaults false)
	 * @return {Object} guiders singleton
	 */
	guiders.hideAll = function ( omitHidingOverlay, next ) {
		next = next || false;

		$( '.guider:visible' ).each( ( index, elem ) => {
			const myGuider = guiders._guiderById( $( elem ).attr( 'id' ) );
			if ( myGuider.onHide ) {
				myGuider.onHide( myGuider, next );
			}
		} );
		guiders._unWireClickOutside();
		// FIXME: Use CSS transition
		// eslint-disable-next-line no-jquery/no-fade
		$( '.guider' ).fadeOut( 'fast' );
		if ( omitHidingOverlay !== true ) {
			guiders._hideOverlay();
		}
		return guiders;
	};

	/**
	 * Show a guider
	 *
	 * @memberof mw.libs.guiders#
	 * @method show
	 * @param {string} id id of guider to show.  The default is the last guider created.
	 * @return {undefined|boolean|Object} Undefined in case of error, return value
	 *   from the guider's onShow, if that is truthy, otherwise the guiders
	 *   singleton.
	 */
	guiders.show = function ( id ) {
		if ( !id && guiders._lastCreatedGuiderID ) {
			id = guiders._lastCreatedGuiderID;
		}

		let myGuider;
		try {
			myGuider = guiders._guiderById( id );
		} catch ( err ) {
			return;
		}

		// You can use an onShow function to take some action before the guider is shown.
		if ( myGuider.onShow ) {
			// if onShow returns something, assume this means you want to bypass the
			//  rest of onShow.
			const showReturn = myGuider.onShow( myGuider );
			if ( showReturn ) {
				return showReturn;
			}
		}
		// handle overlay
		if ( myGuider.overlay ) {
			guiders._showOverlay( myGuider.overlay );
		}
		// bind esc = close action
		if ( myGuider.closeOnEscape ) {
			guiders._wireEscape( myGuider );
		} else {
			guiders._unWireEscape( myGuider );
		}

		if ( myGuider.closeOnClickOutside ) {
			guiders._wireClickOutside( myGuider );
		}

		guiders._attach( myGuider );
		myGuider.elem.fadeIn( 'fast' ).data( 'locked', false );
		guiders._currentGuiderID = id;

		const windowHeight = guiders._windowHeight = $( window ).height();
		const scrollHeight = $( window ).scrollTop();

		// .offset().top returns invalid value (0) when position: absolute
		const stylePosition = myGuider.elem.css( 'position' ) ? myGuider.elem.css( 'position' ).toLowerCase() : '';
		const guiderOffsetTop = stylePosition === 'absolute' ?
			parseFloat( myGuider.elem.css( 'top' ) || 0 ) : myGuider.elem.offset().top;

		const guiderElemHeight = myGuider.elem.height();
		const isGuiderBelow = ( scrollHeight + windowHeight < guiderOffsetTop + guiderElemHeight ); /* we will need to scroll down */
		const isGuiderAbove = ( guiderOffsetTop < scrollHeight ); /* we will need to scroll up */
		if ( myGuider.autoFocus ) {
			if ( isGuiderBelow || isGuiderAbove ) {
				// Sometimes the browser won't scroll if the person just clicked,
				// so let's do this in a setTimeout.
				guiders._removeAnimations( myGuider );
				setTimeout( guiders.scrollToCurrent, 10 );
			}
			$( myGuider.elem ).find( '.cdx-button--action-progressive:first-child' ).trigger( 'focus' );
		}

		$( myGuider.elem ).trigger( 'guiders.show' );

		// Create (preload) next guider if it hasn't been created
		const nextGuiderId = myGuider.next || null;
		if ( nextGuiderId !== null && nextGuiderId !== '' ) {
			const nextGuiderData = guiders._guiderInits[ nextGuiderId ];
			if ( nextGuiderData ) {
				// Only attach if it exists and is :visible
				const testInDom = guiders._getAttachTarget( nextGuiderData );
				if ( testInDom !== null ) {
					guiders.createGuider( nextGuiderData );
				}
			}
		}

		return guiders;
	};

	/**
	 * Scroll to the current guider
	 *
	 * @memberof mw.libs.guiders#
	 * @method scrollToCurrent
	 */
	guiders.scrollToCurrent = function () {
		const currentGuider = guiders._guiders[ guiders._currentGuiderID ];
		if ( typeof currentGuider === 'undefined' ) {
			return;
		}
		const windowHeight = guiders._windowHeight;
		// scrollHeight = $( window ).scrollTop();
		const guiderOffset = currentGuider.elem.offset();
		const guiderElemHeight = currentGuider.elem.height();

		// Scroll to the guider's position.
		const scrollToHeight = Math.round( Math.max( guiderOffset.top + ( guiderElemHeight / 2 ) - ( windowHeight / 2 ), 0 ) );
		// Basic concept from https://github.com/yckart/jquery.scrollto.js/blob/master/jquery.scrollto.js
		$( 'html, body' ).animate( {
			scrollTop: scrollToHeight
		}, guiders._scrollDuration );
	};

	// Change the bubble position after browser gets resized
	let _resizing;
	$( window ).on( 'resize', () => {
		if ( typeof ( _resizing ) !== 'undefined' ) {
			clearTimeout( _resizing ); // Prevents seizures
		}
		_resizing = setTimeout( () => {
			_resizing = undefined;
			if ( typeof ( guiders ) !== 'undefined' ) {
				guiders.reposition();
			}
		}, 20 );
	} );

	$( () => {
		guiders.reposition();
	} );

	return guiders;
} ).call( this );
