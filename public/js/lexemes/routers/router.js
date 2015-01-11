var app = app || {};

var Workspace = Backbone.Router.extend({
	routes: {
		'lexemes': "getAllLexemes",
		'meanings': "getAllMeanings",
		'lexeme/:id': 'findLexeme',
	},
	findLexeme: function (id) {
		console.log(id);
	},
	
	getAllLexemes: function() {
		app.lexiconView = new app.LexiconView();
		app.lexiconView.render();
	},
	
	getAllMeanings: function() {
		
	}
});

app.Router = new Workspace();
Backbone.history.start();
