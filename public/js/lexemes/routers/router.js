var app = app || {};
var Router = Backbone.Router.extend({
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
		app.lexemesView.render();
	},
	
	displayLexeme: function(id) {
		var lexeme = app.lexemesView.findLexeme(id);
		var lexemeView = new app.LexemeView({model: lexeme});
		lexemeView.displayLexeme();
	},
	
	getAllMeanings: function () {
		app.meaningsView.render();
	}
});

app.lexemesView = new app.LexemesView(allLexemes);
app.meaningsView = new app.MeaningsView(allMeanings);
app.Router = new Router();
Backbone.history.start();
