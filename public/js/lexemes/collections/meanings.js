var app = app || {};

app.Meanings = Backbone.Collection.extend({
	model: app.Meaning,
	url: 'meanings'
});


