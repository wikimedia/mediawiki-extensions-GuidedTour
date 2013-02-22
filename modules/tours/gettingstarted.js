// Guided Tour to help users start editing

( function ( window, document, $, mw, gt ) {

/**
 * Gets full page name, without underscores
 *
 * Implemented the same way as E3Experiments
 *
 * @return {string} full page name
 */
function getFullPageName() {
	var pageTitle = mw.config.get( 'wgTitle' ),
		wgNamespaceNumber = mw.config.get( 'wgNamespaceNumber' ),
		pageNamespace = mw.config.get( 'wgFormattedNamespaces' )[ wgNamespaceNumber ];
	if ( pageNamespace ) {
		pageTitle = pageNamespace + ':' + pageTitle;
	}

	return pageTitle;
}

/**
 * Checks whether we should skip this because of the page name.
 *
 * This can use functionality from E3Experiments to determine what task they chose, but
 * it will work either way.
 *
 * It skips everything outside the main namespace (namespace 0).
 *
 * If it's in the namespace, it checks if they have a task.  If they do, it must match.
 *
 * Otherwise, any article counts.
 *
 * @return {boolean} true to skip, false otherwise
 */
function shouldSkipPageName() {
	var tasks, articles, article, pageName, index;

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

	pageName = getFullPageName();
	index = $.inArray( pageName, articles );
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
		shouldSkip: function() {
			// If they're already editing, skip
			return gt.hasQuery( { action: 'edit' } );
		}
	},  {
		titlemsg: 'guidedtour-tour-gettingstarted-click-edit-title',
		descriptionmsg: 'guidedtour-tour-gettingstarted-click-edit-description',
		attachTo: '#ca-edit',
		position: 'bottom',
		shouldSkip: function() {
			return gt.hasQuery( { action: 'edit' } );
		}
	}, {
		titlemsg: 'guidedtour-tour-gettingstarted-click-preview-title',
		descriptionmsg: 'guidedtour-tour-gettingstarted-click-preview-description',
		attachTo: '#wpPreview',
		position: 'top',
		closeOnClickOutside: false,
		shouldSkip: function() {
			return !gt.hasQuery( { action: 'edit' } );
		}
	}, {
		titlemsg: 'guidedtour-tour-gettingstarted-click-save-title',
		descriptionmsg: 'guidedtour-tour-gettingstarted-click-save-description',
		attachTo: '#wpSave',
		position: 'top',
		closeOnClickOutside: false,
		shouldSkip: function() {
			// If they're not previewing or doing show changes, skip
			return !gt.hasQuery( { action: 'submit' } );
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
	shouldLog: true
} );

} (window, document, jQuery, mediaWiki, mediaWiki.guidedTour ) );
