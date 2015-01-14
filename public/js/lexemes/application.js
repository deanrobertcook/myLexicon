var myLexicon = {
	router: null,
	
	Collections: {},
	
	ModelClasses: {},
	CollectionClasses: {},
	ViewClasses: {},
	RouterClasses: {},
	
	/**
	 * Entry point to the application. Initialises main lexeme and meaning 
	 * collections with payload sent as part of initial html payload.
	 */
	main: function() {
		this.Collections.lexemes = new this.CollectionClasses.Lexemes(allLexemes);
		this.Collections.meanings = new this.CollectionClasses.Meanings(allMeanings);
		
		this.router = new this.RouterClasses.Router();
		Backbone.history.start();
	},
	
	log: function() {
		console.log(this);
	}
};


$(function() {
	myLexicon.main();
});