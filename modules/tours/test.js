/*
 * Guided Tour to test guided tour features.
 */
( function ( window, document, $, mw, gt ) {

	// XXX (mattflaschen, 2012-01-02): See GuidedTourHooks.php
	var pageName = mw.config.get( 'wgGuidedTourHelpGuiderUrl' ),
		tour;

	tour = new gt.TourBuilder( {
		/*
		 * This is the name of the tour.  It must be lowercase, without any hyphen (-) or
		 * period (.) characters.
		 *
		 * If this is an on-wiki tour, it should match the MediaWiki page.  For instance,
		 * if this were on-wiki, it would be MediaWiki:Guidedtour-tour-test.js
		 *
		 * The IDs below should use the same name in the middle (e.g. gt-test-2).
		 */
		name: 'test'
	} );

	tour.firstStep( {
		name: 'overlay',
		titlemsg: 'guidedtour-tour-test-testing',
		descriptionmsg: 'guidedtour-tour-test-test-description',
		overlay: true
	} )
	.next( 'callout' );

	tour.step( {
		/*
		 * Callout of left menu
		 */
		name: 'callout',
		titlemsg: 'guidedtour-tour-test-callouts',
		descriptionmsg: 'guidedtour-tour-test-portal-description',
		// attachment
		attachTo: '#n-portal a',
		position: '3'
	} )
	.next( 'description' )
	.back( 'overlay' );

	tour.step( {
		/*
		 * Test out mediawiki description pages
		 */
		name: 'description',
		titlemsg: 'guidedtour-tour-test-description-page',
		description: pageName,

		overlay: true,
		onShow: gt.getPageAsDescription,

		buttons: [ {
			action: 'wikiLink',
			page: pageName,
			namemsg: 'guidedtour-tour-test-go-description-page',
			type: 'progressive'
		}, {
			action: 'end'
		} ]
	} )
	.back( 'callout' );

} ( window, document, jQuery, mediaWiki, mediaWiki.guidedTour ) );
