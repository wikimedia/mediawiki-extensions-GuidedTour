describe( 'template spec', () => {
	it( 'passes', () => {
		cy.visit( '/?tour=uprightdownleft' );
		cy.get( '#gt-uprightdownleft-1' ).should( 'be.visible' );
		cy.get( '.mw-guidedtour-tour-uprightdownleft .guider_title' ).should( 'have.text', 'Up' );
		cy.get( '.mw-guidedtour-tour-uprightdownleft .guidedtour-next-button' ).click();

		cy.get( '#gt-uprightdownleft-1' ).should( 'not.be.visible' );
		cy.get( '#gt-uprightdownleft-2' ).should( 'be.visible' );
		cy.get( '#gt-uprightdownleft-2 .guider_title' ).should( 'have.text', 'Right' );
		cy.get( '#gt-uprightdownleft-2 .guidedtour-next-button' ).click();

		cy.get( '#gt-uprightdownleft-3' ).should( 'be.visible' );
		cy.get( '#gt-uprightdownleft-3 .guider_title' ).should( 'have.text', 'Down' );
		cy.get( '#gt-uprightdownleft-3 .guidedtour-back-button' ).click();

		cy.get( '#gt-uprightdownleft-3' ).should( 'not.be.visible' );
		cy.get( '#gt-uprightdownleft-2' ).should( 'be.visible' );
		cy.get( '#gt-uprightdownleft-2 .guidedtour-next-button' ).click();
		cy.get( '#gt-uprightdownleft-3 .guidedtour-next-button' ).click();

		cy.get( '#gt-uprightdownleft-2' ).should( 'not.be.visible' );
		cy.get( '#gt-uprightdownleft-3' ).should( 'not.be.visible' );
		cy.get( '#gt-uprightdownleft-4' ).should( 'be.visible' );
		cy.get( '#gt-uprightdownleft-4 .guider_title' ).should( 'have.text', 'Left' );
		cy.get( '#gt-uprightdownleft-4 .guidedtour-end-button' ).click();
		cy.get( '#gt-uprightdownleft-4' ).should( 'not.be.visible' );

		cy.visit( '/' );
		cy.wait( 500 );
		cy.get( '.mw-guidedtour-tour-uprightdownleft' ).should( 'not.exist' );
	} );
} );
