var app = app || {};
var Router = Backbone.Router.extend({
	lexiconLoaded: false,
	
	routes: {
		'': "default",
		'lexemes': "getAllLexemes",
		'meanings': "getAllMeanings",
	},
	
	default: function () {
		
	},
	
	getAllLexemes: function () {
		if(this.lexiconLoaded) {
			app.lexiconView.render();
		} else {
			console.log("Lexicon not yet loaded");
		}
	},
	
	getAllMeanings: function () {

	}
});

app.lexiconView = new app.LexiconView();
app.meaningsView = new app.MeaningView();
app.Router = new Router();
Backbone.history.start();
