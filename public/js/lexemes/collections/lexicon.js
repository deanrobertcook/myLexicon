var app = app || {};

app.Lexicon = Backbone.Collection.extend({
	model: app.Lexeme,
	url: 'lexemes'
	
	
});


