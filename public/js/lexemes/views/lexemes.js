var app = app || {};

app.LexemesView = Backbone.View.extend({
	nextId: 0,
	
	tagName: 'div',
	
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
	},
	
	createNewLexeme: function(data) {
		var lexeme = new app.Lexeme(data);
		this.collection.create(lexeme);
		lexeme.set('id', lexeme.cid);
		this.collection.add(lexeme);
		return lexeme.cid;
	}
});