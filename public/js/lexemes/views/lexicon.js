var app = app || {};

app.LexiconView = Backbone.View.extend({
	tagName: 'div',
	
	infoTemplate: _.template($('#lexiconInfo').html()),
	
	events: {},
	
	initialize: function() {
		this.collection = new app.Lexicon();
		this.collection.fetch({
			reset: true,
		});
	},
	
	render: function() {
		$("#lexicon").empty();
		this.$el.empty();
		this.collection.each(function(lexeme) {
			this.renderLexeme(lexeme);
		}, this);
		$("#lexicon").append(this.$el);
	},
	
	renderLexeme: function(lexeme) {
		var lexemeView = new app.LexemeView({
			model: lexeme,
		});
		this.$el.append(lexemeView.render().el);
	},
});