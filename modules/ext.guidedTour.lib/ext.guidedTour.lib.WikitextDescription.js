( function () {
	/**
	 * @class mw.guidedTour.WikitextDescription
	 * @classdesc Wikitext to be used as a step description
	 *
	 * @constructor
	 * @param {string} wikitext Wikitext to use as a description
	 */
	function WikitextDescription( wikitext ) {
		this.wikitext = wikitext;
	}

	/**
	 * Returns specified wikitext
	 *
	 * @return {string} Wikitext for description
	 * @memberof mw.guidedTour.WikitextDescription
	 * @method getWikitext
	 */
	WikitextDescription.prototype.getWikitext = function () {
		return this.wikitext;
	};

	mw.guidedTour.WikitextDescription = WikitextDescription;
}() );
