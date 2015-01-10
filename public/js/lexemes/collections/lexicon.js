var app = app || {};

app.Lexicon = Backbone.Collection.extend({
	model: app.Lexicon,
	url: 'lexemes'
});


