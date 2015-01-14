myLexicon.ViewClasses.LexemesView = Backbone.View.extend({
	nextId: 0,
	
	tagName: 'div',
	
	initialize: function(collection) {
		this.collection = collection;
	},
	
	render: function() {
		this.$el.empty();
		this.collection.each(function(lexeme) {
			this.renderLexeme(lexeme);
		}, this);
		$("#lexicon").html(this.$el);
	},
	
	renderLexeme: function(lexeme) {
		var lexemeView = new myLexicon.ViewClasses.LexemeView({
			model: lexeme,
		});
		this.$el.append(lexemeView.render().el);
	},
	
	createNewLexeme: function(data) {
		var lexeme = new myLexicon.ModelClasses.Lexeme(data);
		this.collection.add(lexeme);
		return lexeme.cid;
	}
});