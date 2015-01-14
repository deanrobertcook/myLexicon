myLexicon.CollectionClasses.Lexemes = Backbone.Collection.extend({
	model: myLexicon.ModelClasses.Lexeme,
	url: 'lexemes',
	
	findLexeme: function(id) {
		var lexeme = this.get(id);
		return lexeme;
	},
});
