( function ( mw, $ ) {
	'use strict';

	var gt, originalPageName, originalGetParam;

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
		var pageNameToSkip = 'TestPage',
			otherPageName = 'WrongPage';

		mw.config.set( 'wgPageName', pageNameToSkip );
		assert.strictEqual(
			gt.isPage( pageNameToSkip ),
			true,
			'Page matches'
		);

		mw.config.set( 'wgPageName', otherPageName );
		assert.strictEqual(
			gt.isPage( pageNameToSkip ),
			false,
			'Page does match'
		);
	} );

	QUnit.test( 'hasQuery', 7, function ( assert ) {
		var paramMap,
			pageNameToSkip = 'RightPage',
			otherPageName = 'OtherPage';

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

		mw.config.set( 'wgPageName', pageNameToSkip );
		assert.strictEqual(
			gt.hasQuery( { action: 'edit' }, pageNameToSkip ),
			true,
			'Query and page both match'
		);

		mw.config.set( 'wgPageName', otherPageName );
		assert.strictEqual(
			gt.hasQuery( { action: 'edit' }, pageNameToSkip ),
			false,
			'Query matches, but page does not');

		paramMap = { debug: 'true', somethingElse: 'medium' };

		assert.strictEqual(
			gt.hasQuery( { action: 'edit' } ),
			false,
			'Query does not match, page is undefined'
		);

		mw.config.set( 'wgPageName', pageNameToSkip );
		assert.strictEqual(
			gt.hasQuery( { action: 'edit' }, pageNameToSkip ),
			false,
			'Query does not match, although page does'
		);

		mw.config.set( 'wgPageName', otherPageName );
		assert.strictEqual(
			gt.hasQuery( { action: 'edit' }, pageNameToSkip ),
			false,
			'Neither query nor page match'
		);
	} );

	QUnit.test( 'getStep', 2, function ( assert ) {
		var step, originalGetParam = mw.util.getParamValue;
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
} ( mediaWiki, jQuery ) );
