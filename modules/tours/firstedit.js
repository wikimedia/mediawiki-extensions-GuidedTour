// Guided Tour to help users make their first edit. Designed to work on any Wikipedia article. 

( function ( window, document, $, mw, guiders ) {

var gt = mw.guidedTour;

gt.currentTour = 'firstedit';

function shouldSkipPageName() {
	// Excludes pages outside the main namespace and pages with editing restrictions
	if ( mw.config.get( 'wgCanonicalNamespace' ) !== '' || mw.config.get( 'wgRestrictionEdit' ).length !== 0 ) {
		return true;
	}

// Just don't initialize the guiders
if ( shouldSkipPageName() ) {
	return;
}

gt.initGuider( {
	id: 'gt-firstedit-1',
	titlemsg: 'guidedtour-tour-firstedit-start-title',
	descriptionmsg: 'guidedtour-tour-firstedit-start-description',
	overlay: true,
	next: 'gt-firstedit-2',
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
	id: 'gt-firstedit-2',
	titlemsg: 'guidedtour-tour-firstedit-click-edit-title',
	descriptionmsg: 'guidedtour-tour-firstedit-click-edit-description',
	attachTo: '#ca-edit',
	position: 'bottom',
	next: 'gt-firstedit-3',
	shouldSkip: function() {
		return gt.hasQuery( { action: 'edit' } );
	}
} );

gt.initGuider( {
	id: 'gt-firstedit-2',
	titlemsg: 'guidedtour-tour-firstedit-click-edit-title',
	descriptionmsg: 'guidedtour-tour-firstedit-click-edit-description',
	attachTo: '#ca-edit',
	position: 'bottom',
	next: 'gt-firstedit-3',
	shouldSkip: function() {
		return gt.hasQuery( { action: 'edit' } );
	}
} );

gt.initGuider( {
	id: 'gt-firstedit-3',
	titlemsg: 'guidedtour-tour-firstedit-click-preview-title',
	descriptionmsg: 'guidedtour-tour-firstedit-click-preview-description',
	attachTo: '#wpPreview',
	position: 'top',
	next: 'gt-firstedit-4',
	closeOnClickOutside: false,
	shouldSkip: function() {
		return !gt.hasQuery( { action: 'edit' } );
	}
} );

gt.initGuider( {
	id: 'gt-firstedit-4',
	titlemsg: 'guidedtour-tour-firstedit-click-save-title',
	descriptionmsg: 'guidedtour-tour-firstedit-click-save-description',
	attachTo: '#wpSave',
	position: 'top',
	next: 'gt-firstedit-5',
	closeOnClickOutside: false,
	shouldSkip: function() {
		// If they're not previewing or doing show changes, skip
		return !gt.hasQuery( { action: 'submit' } );
	}
} );

gt.initGuider( {
	id: 'gt-firstedit-5',
	titlemsg: 'guidedtour-tour-firstedit-end-title',
	descriptionmsg: 'guidedtour-tour-firstedit-end-description',
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
