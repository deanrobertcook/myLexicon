var app = app || {};

var Workspace = Backbone.Router.extend({
	routes: {
		'lexemes': "getAllLexemes",
		'lexeme/:id': 'findLexeme',
	},
	findLexeme: function (id) {
		console.log(id);
	},
	
	getAllLexemes: function() {
		console.log(app.lexiconView);
		app.lexiconView.render();
	}
});

app.Router = new Workspace();
Backbone.history.start();
