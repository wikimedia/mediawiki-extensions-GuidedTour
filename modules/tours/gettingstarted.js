// Guided Tour to help users start editing

( function ( window, document, $, mw, gt ) {

/**
 * Checks whether we should skip this because of the page name.
 *
 * This can use functionality from GettingStarted to determine what task they chose, but
 * it will work either way.
 *
 * Other code in GuidedTour decides to load the gettingstarted tour, but this function will
 * not show it for certain pages:
 *
 * It skips everything outside the main namespace (namespace 0).
 *
 * If it's in the main namespace, it checks if they have a task.  If they do, it must match.
 * If they have no task, the tour will be shown for any article.
 *
 * @return {boolean} true to skip, false otherwise
 */
function shouldSkipPageName() {
	var tasks, articles, article, wgPageName, fullPageTitle, index;

	if ( mw.config.get( 'wgCanonicalNamespace' ) !== '' ) {
		return true;
	}

	tasks = $.parseJSON( $.cookie( 'openTask' ) );
	articles = [];

	// We'll filter by their tasks if they have any.
	if ( $.isPlainObject( tasks ) ) {
		for ( article in tasks ){
			articles.push( article );
		}
	}

	// If they don't have any, any article counts.
	if ( articles.length === 0 ) {
		return false;
	}

	wgPageName = mw.config.get( 'wgPageName' );
	fullPageTitle = new mw.Title( wgPageName ).getPrefixedText();
	index = $.inArray( fullPageTitle, articles );
	return index === -1;
}

// Just don't initialize the guiders
if ( shouldSkipPageName() ) {
	return;
}

gt.defineTour( {
	name: 'gettingstarted',
	steps: [ {
		titlemsg: 'guidedtour-tour-gettingstarted-start-title',
		descriptionmsg: 'guidedtour-tour-gettingstarted-start-description',
		overlay: true,
		buttons: [ {
			action: 'next'
		} ],

		// TODO (mattflaschen 2013-02-05): Factor out into lib.  Also, it should probably use wgAction, rather than query.
		shouldSkip: gt.isEditing
	},  {
		titlemsg: 'guidedtour-tour-gettingstarted-click-edit-title',
		descriptionmsg: 'guidedtour-tour-gettingstarted-click-edit-description',
		attachTo: '#ca-edit',
		position: 'bottom',
		shouldSkip: gt.isEditing
	}, {
		titlemsg: 'guidedtour-tour-gettingstarted-click-preview-title',
		descriptionmsg: 'guidedtour-tour-gettingstarted-click-preview-description',
		attachTo: '#wpPreview',
		position: 'top',
		closeOnClickOutside: false,
		shouldSkip: function() {
			return !gt.isEditing();
		}
	}, {
		titlemsg: 'guidedtour-tour-gettingstarted-click-save-title',
		descriptionmsg: 'guidedtour-tour-gettingstarted-click-save-description',
		attachTo: '#wpSave',
		position: 'top',
		closeOnClickOutside: false,
		shouldSkip: function() {
			return !gt.isReviewing();
		}
	}, {
		titlemsg: 'guidedtour-tour-gettingstarted-end-title',
		descriptionmsg: 'guidedtour-tour-gettingstarted-end-description',
		overlay: true,
		shouldSkip: function() {
			// Skip this if the user hasn't just saved.
			return !gt.isPostEdit();
		},
		buttons: [ {
			action: 'end'
		} ]
	} ],
	shouldLog: true,
	showConditionally: 'stickToFirstPage'
} );

} (window, document, jQuery, mediaWiki, mediaWiki.guidedTour ) );
