var app = app || {};
var Router = Backbone.Router.extend({
	lexemesLoaded: false,
	
	routes: {
		'': "default",
		'lexemes': "getAllLexemes",
		'meanings': "getAllMeanings",
	},
	
	default: function () {
		
	},
	
	getAllLexemes: function () {
		if(this.lexemesLoaded) {
			app.lexemesView.render();
		} else {
			console.log("Lexicon not yet loaded");
		}
	},
	
	getAllMeanings: function () {

	}
});

app.lexemesView = new app.LexemesView();
app.meaningsView = new app.MeaningView();
app.Router = new Router();
Backbone.history.start();
