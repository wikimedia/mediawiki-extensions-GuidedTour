// Guided Tour to help users make their first edit.
// Designed to work on any Wikipedia article, and can work for other sites with minor message changes.

( function ( window, document, $, mw, gt ) {
	var hasEditSection, isVeInstalled;

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

	// We don't care if VE is actually available on the page.
	// If it is installed, it controls the edit link messages, even if VE is not available.
	//
	// VE actually allows configuring this through $wgVisualEditorTabMessages, but we assume the defaults.
	//
	// We fork messages only when necessary, based on whether VE is installed.  The messages with 'visualeditor'
	// in the name include the VE messages through {{int:}}
	isVeInstalled = !!mw.libs.ve;
	gt.defineTour( {
		name: 'firstedit',
		steps: [ {
			titlemsg: 'guidedtour-tour-firstedit-edit-page-title',
			descriptionmsg: isVeInstalled ?
				'guidedtour-tour-firstedit-edit-page-visualeditor-description' :
				'guidedtour-tour-firstedit-edit-page-description',
			attachTo: '#ca-edit',
			position: 'bottom',
			// TODO (mattflaschen, 2013-09-03): After GuidedTour API enhancements, try to replace
			// section-related shouldSkip and onclick code with proceedTo.
			shouldSkip: gt.isEditing,
			buttons: [ {
				namemsg: hasEditSection ? 'guidedtour-next-button' : 'guidedtour-okay-button',
				onclick: function () {
					if ( hasEditSection ) {
						mw.libs.guiders.next();
					} else {
						mw.libs.guiders.hideAll();
					}
				}
			} ],
			allowAutomaticOkay: false
		}, {
			titlemsg: 'guidedtour-tour-firstedit-edit-section-title',
			descriptionmsg: isVeInstalled ?
				'guidedtour-tour-firstedit-edit-section-visualeditor-description' :
				'guidedtour-tour-firstedit-edit-section-description',
			position: 'right',
			attachTo: '.mw-editsection',
			autoFocus: true,
			width: 300,
			shouldSkip: function () {
				return gt.isEditing() || $( '.mw-editsection' ).length === 0;
			}
		}, {
			titlemsg: 'guidedtour-tour-firstedit-preview-title',
			descriptionmsg: 'guidedtour-tour-firstedit-preview-description',
			attachTo: '#wpPreview',
			autoFocus: true,
			position: 'top',
			closeOnClickOutside: false,
			shouldSkip: function() {
				return !gt.isEditing();
			}
		},  {
			titlemsg: 'guidedtour-tour-firstedit-save-title',
			descriptionmsg: 'guidedtour-tour-firstedit-save-description',
			attachTo: '#wpSave',
			autoFocus: true,
			position: 'top',
			closeOnClickOutside: false,
			shouldSkip: function() {
				return !gt.isReviewing();
			}
		} ]
	} );

} (window, document, jQuery, mediaWiki, mediaWiki.guidedTour ) );
