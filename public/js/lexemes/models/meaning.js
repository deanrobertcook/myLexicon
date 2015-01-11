var app = app || {};

app.Meaning = Backbone.Model.extend({
	defaults: {
		frequency: 1,
		dateEntered: this.getDate(),
	},
	
	getDate: function() {
		return Date.now();
	}
});