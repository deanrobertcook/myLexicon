var app = app || {};
var Router = Backbone.Router.extend({
	routes: {
		'': "default",
		'lexemes': "getAllLexemes",
		'meanings': "getAllMeanings",
	},
	
	default: function () {
		this.getAllMeanings();
	},
	
	getAllLexemes: function () {
		app.lexemesView.render();
	},
	
	getAllMeanings: function () {
		app.meaningsView.render();
	}
});

app.lexemesView = new app.LexemesView(lexemes);
app.meaningsView = new app.MeaningsView(meanings);
app.Router = new Router();
Backbone.history.start();
