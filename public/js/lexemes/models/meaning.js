var app = app || {};

app.Meaning = Backbone.Model.extend({
	defaults: {
		frequency: 1,
		dateEntered: Date.now(),
	},
});