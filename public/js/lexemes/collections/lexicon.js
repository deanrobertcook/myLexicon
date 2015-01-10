var app = app || {};

app.Lexicon = Backbone.Collection.extend({
	model: app.Meaning,
	url: 'lexemes'
});


