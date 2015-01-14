myLexicon.RouterClasses.Router = Backbone.Router.extend({
	routes: {
		'': "default",
		'lexemes': "getAllLexemes",
		'lexemes/:id': "displayLexeme",
		'meanings': "getAllMeanings",
	},
	
	default: function () {
		this.getAllMeanings();
	},
	
	/**
	 * Shows all bare lexemes within the users main collection without any links
	 * to any meanings
	 */
	getAllLexemes: function () {
		var lexemesView = new myLexicon.ViewClasses.LexemesView(myLexicon.Collections.lexemes);
		lexemesView.render();
	},
	
	/**
	 * For a given lexeme, all associated meanings are displayed from the main
	 * collection
	 * @param {int} id
	 */
	displayLexeme: function(id) {
		var lexeme = myLexicon.Collections.lexemes.get(id);
		var lexemeView = new myLexicon.ViewClasses.LexemeView({model: lexeme});
		lexemeView.displayLexeme();
	},
	
	/**
	 * Shows all meanings (and their associated lexemes) that are stored in the 
	 * user's main collection
	 */
	getAllMeanings: function () {
		var meaningsView = new myLexicon.ViewClasses.MeaningsView(myLexicon.Collections.meanings);
		meaningsView.render();
	}
}); 

