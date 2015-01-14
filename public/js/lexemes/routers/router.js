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
	
	getAllLexemes: function () {
		var lexemesView = new myLexicon.ViewClasses.LexemesView(myLexicon.Collections.lexemes);
		lexemesView.render();
	},
	
	displayLexeme: function(id) {
		var lexeme = myLexicon.Collections.lexemes.findLexeme(id);
		var lexemeView = new myLexicon.ViewClasses.LexemeView({model: lexeme});
		lexemeView.displayLexeme();
	},
	
	getAllMeanings: function () {
		var meaningsView = new myLexicon.ViewClasses.MeaningsView(myLexicon.Collections.meanings);
		meaningsView.render();
	}
}); 

