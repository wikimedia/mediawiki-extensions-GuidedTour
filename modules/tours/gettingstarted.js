// Guided Tour to help users start editing

( function ( window, document, $, mw, guiders ) {

var gt = mw.guidedTour = mw.guidedTour || {};

gt.currentTour = 'gettingstarted';

/*
 * Checks whether we should skip this because of the page name.
 *
 * This can use functionality from E3Experiments to determine what task they chose, but
 * it will work either way.
 *
 * @return true to skip, false otherwise
 */
function shouldSkipPageName() {
	var tasks = $.parseJSON( $.cookie( 'openTask' ) );
	var articles = [], article;

	// We'll filter by their tasks if they have any.
	if ( $.isPlainObject( tasks ) ) {
		for ( article in tasks ){
			articles.push( mw.util.wikiUrlencode( article ) );
		}
	}

	// If they don't have any, any page counts.
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
		namemsg: 'guidedtour-start-tour',
		onclick: guiders.next
	} ]
} );

gt.initGuider( {
	id: 'gt-gettingstarted-2',
	titlemsg: 'guidedtour-tour-gettingstarted-click-edit-title',
	descriptionmsg: 'guidedtour-tour-gettingstarted-click-edit-description',
	attachTo: '#ca-edit',
	position: 'bottom',
	next: 'gt-gettingstarted-3',
	shouldSkip: function() {
		// If they're already editing, skip
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
	shouldSkip: function() {
		// If they're already previewing, doing show changes, or done, skip.
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
		namemsg: 'guidedtour-end-tour',
		onclick: gt.endTour
	} ]
} );



} (window, document, jQuery, mediaWiki, mediaWiki.libs.guiders) );
