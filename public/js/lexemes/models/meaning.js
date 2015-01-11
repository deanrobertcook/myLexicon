var app = app || {};

app.Meaning = Backbone.Model.extend({
	defaults: {
		frequency: 1,
		dateEntered: (new Date()).toMysqlFormat(),
	},
	
	push: function() {
		var targetLexeme = app.lexemesView.findLexeme(this.get('targetid'));
		var baseLexeme = app.lexemesView.findLexeme(this.get('baseid'));
		
//		app.lexemesView.collection.create(targetLexeme);
//		app.lexemesView.collection.create(baseLexeme);
	}
});