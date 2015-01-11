var app = app || {};

app.LexemesView = Backbone.View.extend({
	tagName: 'div',
	
	events: {},
	
	initialize: function(initialLexemes) {
		this.collection = new app.Lexemes(initialLexemes);
	},
	
	render: function() {
		this.$el.empty();
		this.collection.each(function(lexeme) {
			this.renderLexeme(lexeme);
		}, this);
		$("#lexicon").html(this.$el);
	},
	
	renderLexeme: function(lexeme) {
		var lexemeView = new app.LexemeView({
			model: lexeme,
		});
		this.$el.append(lexemeView.render().el);
	},
	
	findLexeme: function(id) {
		var lexeme = this.collection.get(id);
		return lexeme;
	}
});