var app = app || {};

app.Lexemes = Backbone.Collection.extend({
	model: app.Lexeme,
	url: 'lexemes'
});
