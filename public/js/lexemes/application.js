var myLexicon = {
	router: null,
	
	Collections: {},
	
	ModelClasses: {},
	CollectionClasses: {},
	ViewClasses: {},
	RouterClasses: {},
	
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