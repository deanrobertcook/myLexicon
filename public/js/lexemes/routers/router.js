myLexicon.RouterClasses.Router = Backbone.Router.extend({
	routes: {
		'': "default",
		'lexemes': "getAllLexemes",
		'lexemes/:id': "displayLexeme",
		'meanings': "meanings",
		'meanings/:pageNo': "meaningsPage",
	},
	
	default: function () {
		this.meanings();
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
	
	meanings: function () {
		this.meaningsPage(1);
	},
	
	meaningsPage: function (pageNo) {
		pageNo = parseInt(pageNo);
		var page = myLexicon.Collections.meanings.getPage(pageNo);
		var meaningsView = new myLexicon.ViewClasses.MeaningsView(page);
		meaningsView.render();
	}
}); 

