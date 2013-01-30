// Guided Tour to help users start editing

( function ( window, document, $, mw, guiders ) {

var gt = mw.guidedTour;

gt.currentTour = 'gettingstarted';

/*
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
 * @return true to skip, false otherwise
 */
function shouldSkipPageName() {
	if ( mw.config.get( 'wgCanonicalNamespace' ) !== '' ) {
		return true;
	}

	var tasks = $.parseJSON( $.cookie( 'openTask' ) );
	var articles = [], article;

	// We'll filter by their tasks if they have any.
	if ( $.isPlainObject( tasks ) ) {
		for ( article in tasks ){
			articles.push( mw.util.wikiUrlencode( article ) );
		}
	}

	// If they don't have any, any article counts.
	if ( articles.length === 0 ) {
		return false;
	}

	var pageName = mw.config.get( 'wgPageName' );
	var index = $.inArray( pageName, articles );
	return index === -1;
}

// Just don't initialize the guiders
if ( shouldSkipPageName() ) {
	return;
}

gt.initGuider( {
	id: 'gt-gettingstarted-1',
	titlemsg: 'guidedtour-tour-gettingstarted-start-title',
	descriptionmsg: 'guidedtour-tour-gettingstarted-start-description',
	overlay: true,
	next: 'gt-gettingstarted-2',
	buttons: [ {
		action: 'next'
	} ],
        // TODO: Factor out into lib.  Also, it should probably use wgAction, rather than query.
        shouldSkip: function() {
		// If they're already editing, skip
		return gt.hasQuery( { action: 'edit' } );
	}

} );

gt.initGuider( {
	id: 'gt-gettingstarted-2',
	titlemsg: 'guidedtour-tour-gettingstarted-click-edit-title',
	descriptionmsg: 'guidedtour-tour-gettingstarted-click-edit-description',
	attachTo: '#ca-edit',
	position: 'bottom',
	next: 'gt-gettingstarted-3',
	shouldSkip: function() {
		return gt.hasQuery( { action: 'edit' } );
	}
} );

gt.initGuider( {
	id: 'gt-gettingstarted-3',
	titlemsg: 'guidedtour-tour-gettingstarted-click-preview-title',
	descriptionmsg: 'guidedtour-tour-gettingstarted-click-preview-description',
	attachTo: '#wpPreview',
	position: 'top',
	next: 'gt-gettingstarted-4',
	closeOnClickOutside: false,
	shouldSkip: function() {
		return !gt.hasQuery( { action: 'edit' } );
	}
} );

gt.initGuider( {
	id: 'gt-gettingstarted-4',
	titlemsg: 'guidedtour-tour-gettingstarted-click-save-title',
	descriptionmsg: 'guidedtour-tour-gettingstarted-click-save-description',
	attachTo: '#wpSave',
	position: 'top',
	next: 'gt-gettingstarted-5',
	closeOnClickOutside: false,
	shouldSkip: function() {
		// If they're not previewing or doing show changes, skip
		return !gt.hasQuery( { action: 'submit' } );
	}
} );

gt.initGuider( {
	id: 'gt-gettingstarted-5',
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
} );



} (window, document, jQuery, mediaWiki, mediaWiki.libs.guiders) );
