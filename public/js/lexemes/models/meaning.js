var app = app || {};

app.Meaning = Backbone.Model.extend({
	model: {
		targetLexeme: app.Lexeme,
		baseLexeme: app.Lexeme,
	},
});