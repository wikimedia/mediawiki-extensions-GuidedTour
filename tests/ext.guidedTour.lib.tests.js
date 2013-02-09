( function ( mw, $ ) {
	'use strict';

	var gt, originalPageName, originalGetParam,
		// This form includes the id and next.
		VALID_SPEC = {
			id: 'gt-test-1',
			titlemsg: 'guidedtour-tour-test-callouts',
			descriptionmsg: 'guidedtour-tour-test-portal-description',
			attachTo: '#n-portal a',
			position: '3',
			next: 'gt-test-2',
			buttons: [ {
				action: 'next'
			} ]
		};

	// QUnit throws only lets you check one at a time
	function assertThrowsTypeAndMessage( assert, block, errorConstructor, regexErrorMessage, message ) {
		var actualException;
		try {
			block();
		} catch ( exc ) {
			actualException = exc;
		}

		assert.ok( actualException instanceof errorConstructor, message );
		assert.ok( regexErrorMessage.test( actualException ), message );
	}

	QUnit.module( 'ext.guidedTour.lib', QUnit.newMwEnvironment( {
		setup: function () {
			gt = mw.guidedTour;
			originalPageName = mw.config.get( 'wgPageName' );
			originalGetParam = mw.util.getParamValue;
		},
		teardown: function () {
			mw.util.getParamValue = originalGetParam;
			mw.config.set( 'wgPageName', originalPageName );
		}
	} ) );

	QUnit.test( 'parseTourId', 1, function ( assert ) {
		var tourId = 'gt-test-2', expectedTourInfo;
		expectedTourInfo = {
			name: 'test',
			step: '2'
		};
		assert.deepEqual(
			gt.parseTourId(	tourId ),
			expectedTourInfo,
			'Simple tourId'
		);
	} );

	QUnit.test( 'isPage', 2, function ( assert ) {
		var PAGE_NAME_TO_SKIP = 'TestPage',
			OTHER_PAGE_NAME = 'WrongPage';

		mw.config.set( 'wgPageName', PAGE_NAME_TO_SKIP );
		assert.strictEqual(
			gt.isPage( PAGE_NAME_TO_SKIP ),
			true,
			'Page matches'
		);

		mw.config.set( 'wgPageName', OTHER_PAGE_NAME );
		assert.strictEqual(
			gt.isPage( PAGE_NAME_TO_SKIP ),
			false,
			'Page does match'
		);
	} );

	QUnit.test( 'hasQuery', 7, function ( assert ) {
		var paramMap,
			PAGE_NAME_TO_SKIP = 'RightPage',
			OTHER_PAGE_NAME = 'OtherPage';

		mw.util.getParamValue =	function ( param ) {
			return paramMap[param];
		};

		paramMap = { action: 'edit', debug: 'true' };

		assert.strictEqual(
			gt.hasQuery( { action: 'edit' } ),
			true,
			'Query matches, page name is undefined'
		);
		assert.strictEqual(
			gt.hasQuery( { action: 'edit' }, null ),
			true,
			'Query matches, page name is null'
		);

		mw.config.set( 'wgPageName', PAGE_NAME_TO_SKIP );
		assert.strictEqual(
			gt.hasQuery( { action: 'edit' }, PAGE_NAME_TO_SKIP ),
			true,
			'Query and page both match'
		);

		mw.config.set( 'wgPageName', OTHER_PAGE_NAME );
		assert.strictEqual(
			gt.hasQuery( { action: 'edit' }, PAGE_NAME_TO_SKIP ),
			false,
			'Query matches, but page does not');

		paramMap = { debug: 'true', somethingElse: 'medium' };

		assert.strictEqual(
			gt.hasQuery( { action: 'edit' } ),
			false,
			'Query does not match, page is undefined'
		);

		mw.config.set( 'wgPageName', PAGE_NAME_TO_SKIP );
		assert.strictEqual(
			gt.hasQuery( { action: 'edit' }, PAGE_NAME_TO_SKIP ),
			false,
			'Query does not match, although page does'
		);

		mw.config.set( 'wgPageName', OTHER_PAGE_NAME );
		assert.strictEqual(
			gt.hasQuery( { action: 'edit' }, PAGE_NAME_TO_SKIP ),
			false,
			'Neither query nor page match'
		);
	} );

	QUnit.test( 'getStep', 2, function ( assert ) {
		var step;
		mw.util.getParamValue = function () {
			return step;
		};

		step = 6;
		assert.strictEqual(
			gt.getStep(),
			step,
			'Step is returned correctly when present'
		);

		step = null;
		assert.strictEqual(
			gt.getStep(),
			step,
			'Step is returned as null when not present'
		);
	} );

	QUnit.test( 'setTourCookie', 3, function ( assert ) {
		var cookieName = mw.libs.guiders.cookie,
			name = 'foo',
			numberStep = 5,
			stringStep = '3';

		function assertValidCookie( expectedName, expectedStep, message ) {
			var id = $.cookie( cookieName ),
				tourInfo = gt.parseTourId( id );

			assert.deepEqual(tourInfo, {
				name: expectedName,
				step: expectedStep
			}, message);
		}

		gt.setTourCookie( name );
		assertValidCookie ( name, '1', 'Step defaults to 1' );

		gt.setTourCookie( name, numberStep );
		assertValidCookie ( name, String( numberStep ), 'setTourCookie accepts numeric step' );

		gt.setTourCookie( name, stringStep );
		assertValidCookie ( name, stringStep, 'setTourCookie accepts string step' );

		mw.libs.guiders.endTour();
	} );

	QUnit.test( 'defineTour', 11, function ( assert ) {
		var SPEC_MUST_BE_OBJECT = /There must be a single argument, 'tourSpec', which must be an object\./,
			NAME_MUST_BE_STRING = /'tourSpec.name' must be a string, the tour name\./,
			STEPS_MUST_BE_ARRAY = /'tourSpec.steps' must be an array, the list of steps\./,
			validDefineTourStep = $.extend( true, {}, VALID_SPEC );

		delete validDefineTourStep.id;
		delete validDefineTourStep.next;

		assertThrowsTypeAndMessage(
			assert,
			function () {
				return gt.defineTour();
			},
			gt.TourDefinitionError,
			SPEC_MUST_BE_OBJECT,
			'gt.TourDefinitionError with correct error message for empty call'
		);

		assertThrowsTypeAndMessage(
			assert,
			function () {
				return gt.defineTour( null );
			},
			gt.TourDefinitionError,
			SPEC_MUST_BE_OBJECT,
			'gt.TourDefinitionError with correct error message for null call'
		);

		assertThrowsTypeAndMessage(
			assert,
			function () {
				return gt.defineTour( {
					steps: [ validDefineTourStep ]
				} );
			},
			gt.TourDefinitionError,
			NAME_MUST_BE_STRING,
			'gt.TourDefinitionError with correct error message for missing name'
		);

		assertThrowsTypeAndMessage(
			assert,
			function () {
				return gt.defineTour( {
					name: 'test',
					steps: validDefineTourStep
				} );
			},
			gt.TourDefinitionError,
			STEPS_MUST_BE_ARRAY,
			'gt.TourDefinitionError with correct error message for object passed for steps'
		);

		assertThrowsTypeAndMessage(
			assert,
			function () {
				return gt.defineTour( {
					name: 'test'
				} );
			},
			gt.TourDefinitionError,
			STEPS_MUST_BE_ARRAY,
			'gt.TourDefinitionError with correct error message for missing steps'
		);

		assert.ok(
			function () {
				return gt.defineTour( {
					name: 'valid',

					steps: [ {
						titlemsg: 'guidedtour-tour-test-testing',
						descriptionmsg: 'guidedtour-tour-test-test-description',
						overlay: true,
						buttons: [ {
							action: 'next'
						} ]
					}, {
						title: 'Valid title',
						description: 'Valid description',
						overlay: true,
						buttons: [ {
							action: 'end'
						} ]
					} ]
				} );
			},
			'Valid tour is defined successfully'
		);
	} );

	QUnit.test( 'initGuider', 7, function( assert ) {
		var ID_MISSING = /'options.id' must be a string, in the form gt-tourname-stepnumber\./,
			NEXT_MISSING = /'options.next' must be a string, in the form gt-tourname-stepnumber\./,
			PREV_BAD_ACTION = /'prev' is not a supported button action\./,
			guiderWithMissingId = $.extend( true, {}, VALID_SPEC ),
			guiderWithMissingNext = $.extend( true, {}, VALID_SPEC ),
			guiderWithBadAction = $.extend( true, {}, VALID_SPEC );

		delete guiderWithMissingId.id;
		delete guiderWithMissingNext.next;

		guiderWithBadAction.buttons[0].action = 'prev';

		assertThrowsTypeAndMessage(
			assert,
			function () {
				return gt.initGuider( guiderWithMissingId );
			},
			gt.TourDefinitionError,
			ID_MISSING,
			'gt.TourDefinitionError with correct error message for missing id field'
		);

		assertThrowsTypeAndMessage(
			assert,
			function () {
				return gt.initGuider( guiderWithMissingNext );
			},
			gt.TourDefinitionError,
			NEXT_MISSING,
			'gt.TourDefinitionError with correct error message for missing next field'
		);

		assertThrowsTypeAndMessage(
			assert,
			function () {
				return gt.initGuider( guiderWithBadAction );
			},
			gt.TourDefinitionError,
			PREV_BAD_ACTION,
			'gt.TourDefinitionError with correct error message for bad \'prev\' action'
		);

		assert.ok(
			gt.initGuider( VALID_SPEC ),
			'Valid call succeeds'
		);
	} );
} ( mediaWiki, jQuery ) );
