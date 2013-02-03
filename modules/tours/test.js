/*
 * Guided Tour to test guided tour features.
 */
( function ( window, document, $, mw, guiders ) {

var gt = mw.guidedTour;

/*
 * This is the name of the tour.  It must be lowercase, without any hyphen (-) or
 * period (.) characters.
 *
 * If this is an on-wiki tour, it should match the MediaWiki page.  For instance,
 * if this were on-wiki, it would be MediaWiki:Guidedtour-tour-test.js
 *
 * The IDs below should use the same name in the middle (e.g. gt-test-2).
 */
gt.currentTour = 'test';

/*
 * Show overlay
 */
gt.initGuider({
	id: "gt-test-1",
	titlemsg: 'guidedtour-tour-test-testing',
	descriptionmsg: 'guidedtour-tour-test-test-description',

	// attachment
	overlay: true,

	next: "gt-test-2",
	buttons: [ {
		action: 'next'
	} ]
});

/*
 * Callout of left menu
 */
gt.initGuider({
	id: "gt-test-2",
	titlemsg: 'guidedtour-tour-test-callouts',
	descriptionmsg: 'guidedtour-tour-test-portal-description',

	// attachment
	//overlay: true,
	attachTo: '#n-portal a',
	position: '3',


	next: "gt-test-3",
	buttons: [ {
		action: 'next'
	} ]
});

/*
 * Test out mediawiki parsing
 */
gt.initGuider({
	id: "gt-test-3",
	titlemsg: 'guidedtour-tour-test-mediawiki-parse',
	// XXX (mattflaschen, 2012-01-02): See GuidedTourHooks.php
	description: mw.config.get('wgGuidedTourTestWikitextDescription'),

	// attachment
	attachTo: '#searchInput',
	position: 'bottomRight', //try descriptive position (5'oclock)

	next: "gt-test-4",
	buttons: [ {
		action: 'next'
	} ]
});

/*
 * Test out mediawiki description pages
 */
// XXX (mattflaschen, 2012-01-02): See GuidedTourHooks.php
var pageName = mw.config.get( 'wgGuidedTourHelpUrl' );
gt.initGuider({
	id: "gt-test-4",
	titlemsg: 'guidedtour-tour-test-description-page',
	description: pageName,

	// attachment
	overlay: true,
	onShow: gt.getPageAsDescription,

	next: "gt-test-5",
	buttons: [ {
		namemsg: 'guidedtour-tour-test-go-description-page',
		onclick: function() {
			window.location = mw.util.wikiGetlink(pageName);
			return false;
		}
	}, {
		action: 'end'
	} ]
});


} (window, document, jQuery, mediaWiki, mediaWiki.libs.guiders) );
