var app = app || {};

app.LexiconView = Backbone.View.extend({
	el: '#lexemes',
	
	initialize: function(initialLexemes) {
		console.log(app);
		console.log(initialLexemes);
		this.collection = new app.Lexicon(initialLexemes);
//		this.collection.fetch({
//			reset: true,
//		});
		this.render();
		
//		this.listenTo(this.collection, 'add', this.renderLexeme);
		this.listenTo(this.collection, 'reset', this.render);
	},
	
	render: function() {
		this.collection.each(function(item) {
			this.renderLexeme(item);
		}, this);
	},
	
	renderLexeme: function(item) {
		var lexemeView = new app.LexemeView({
			model: item,
		});
		this.$el.append(lexemeView.render().el);
	}
});