// Guided Tour to help users make their first edit.
// Designed to work on any Wikipedia article, and can work for other sites with minor message changes.

( function ( window, document, $, mw, gt ) {
	var hasEditSection, tour, editPageButtons = [];

	function shouldShowForPage() {
		// Excludes pages outside the main namespace and pages with editing restrictions
		// Should be 'pages that are not in content namespaces'.
		// However, the list of content namespaces isn't currently exposed to JS.
		return ( mw.config.get( 'wgCanonicalNamespace' ) === '' && mw.config.get( 'wgIsProbablyEditable' ) );
	}

	// If we shouldn't show it, don't initialize the guiders
	if ( !shouldShowForPage() ) {
		return;
	}

	hasEditSection = $( '.mw-editsection' ).length > 0;

	if ( hasEditSection ) {
		editPageButtons.push( {
			action: 'next'
		} );
	}

	tour = new gt.TourBuilder( {
		name: 'firstedit',
		shouldLog: true
	} );

	tour.firstStep( {
		name: 'intro',
		titlemsg: 'guidedtour-tour-firstedit-edit-page-title',
		descriptionmsg: 'guidedtour-tour-firstedit-edit-page-description',
		attachTo: '#ca-edit',
		position: 'bottom',
		buttons: editPageButtons
	} )
	.transition( function () {
		if ( gt.isEditing() ) {
			return 'preview';
		}
	} )
	.next( 'editSection' );

	tour.step( {
		name: 'editSection',
		titlemsg: 'guidedtour-tour-firstedit-edit-section-title',
		descriptionmsg: 'guidedtour-tour-firstedit-edit-section-description',
		position: 'right',
		attachTo: '.mw-editsection',
		autoFocus: true,
		width: 300
	} )
	.transition( function () {
		if ( gt.isEditing() ) {
			return 'preview';
		} else if ( !hasEditSection ) {
			return gt.TransitionAction.HIDE;
		}
	} );

	tour.step( {
		name: 'preview',
		titlemsg: 'guidedtour-tour-firstedit-preview-title',
		descriptionmsg: 'guidedtour-tour-firstedit-preview-description',
		attachTo: '#wpPreview',
		autoFocus: true,
		position: 'top',
		closeOnClickOutside: false
	} )
	.transition( function () {
		if ( gt.isReviewing() ) {
			return 'save';
		}
	} );

	tour.step( {
		name: 'save',
		titlemsg: 'guidedtour-tour-firstedit-save-title',
		descriptionmsg: 'guidedtour-tour-firstedit-save-description',
		attachTo: '#wpSave',
		autoFocus: true,
		position: 'top',
		closeOnClickOutside: false
	} )
	.transition( function () {
		if ( !gt.isReviewing() ) {
			return gt.TransitionAction.END;
		}
	} );

} (window, document, jQuery, mediaWiki, mediaWiki.guidedTour ) );
