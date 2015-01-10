var app = app || {};

app.LexiconView = Backbone.View.extend({
	el: '#lexicon',
	
	initialize: function() {
		this.collection = new app.Lexicon();
		this.collection.fetch({
			reset: true,
		});
		this.render();
		
		this.listenTo(this.collection, 'add', this.renderLexeme);
		this.listenTo(this.collection, 'reset', this.render);
	},
	
	render: function() {
		this.collection.each(function(meaning) {
			this.renderMeaning(meaning);
		}, this);
	},
	
	renderMeaning: function(meaning) {
		var meaningView = new app.MeaningView({
			model: meaning,
		});
		this.$el.append(meaningView.render().el);
	},
	
	renderLexeme: function(lexeme) {
		var lexemeView = new app.LexemeView({
			model: lexeme,
		});
		this.$el.append(lexemeView.render().el);
	}
});