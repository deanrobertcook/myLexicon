var app = app || {};
var Router = Backbone.Router.extend({
	lexemesLoaded: false,
	meaningsLoaded: false,
	
	routes: {
		'': "default",
		'lexemes': "getAllLexemes",
		'meanings': "getAllMeanings",
	},
	
	default: function () {
		this.getAllMeanings();
	},
	
	getAllLexemes: function () {
		if(this.lexemesLoaded) {
			app.lexemesView.render();
		} else {
			console.log("Lexicon not yet loaded");
		}
	},
	
	getAllMeanings: function () {
		if(this.meaningsLoaded) {
			app.meaningsView.render();
		} else {
			console.log("Meanings not yet loaded");
		}
	}
});

app.lexemesView = new app.LexemesView();
app.meaningsView = new app.MeaningView();
app.Router = new Router();
Backbone.history.start();
