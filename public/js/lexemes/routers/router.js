var app = app || {};

var Workspace = Backbone.Router.extend({
	routes: {
		'lexeme/:id': 'findLexeme',
	},
	findLexeme: function (id) {
		console.log(id);
	},
});

app.Router = new Workspace();
Backbone.history.start();
