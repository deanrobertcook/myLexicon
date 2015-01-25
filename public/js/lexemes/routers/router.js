myLexicon.RouterClasses.Router = Backbone.Router.extend({
	applicationAnchor: $("#lexicon"),
	
	routes: {
		'': "default",
		'lexemes': "getAllLexemes",
		'lexemes/:id': "displayLexeme",
		'meanings': "meanings",
		'meanings/:pageNo': "meaningsPage",
		'new-meaning': "newMeaning",
	},
	
	default: function () {
		this.meaningsPage(1);
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
		console.log("made it here");
		this.meaningsPage(1);
	},
	
	meaningsPage: function (pageNo) {
		pageNo = parseInt(pageNo);
		var page = myLexicon.Collections.meanings.getPage(pageNo);
		var meaningsView = new myLexicon.ViewClasses.MeaningsView(page);
		meaningsView.render();
	},
	
	newMeaning: function() {
		var navigationBar = new myLexicon.ViewClasses.NavigationBar();
		this.applicationAnchor.html(navigationBar.render().el)
		
		var newMeaningView = new myLexicon.ViewClasses.NewMeaningView();
		this.applicationAnchor.append(newMeaningView.render().el)
	}
}); 

