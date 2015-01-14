myLexicon.CollectionClasses.Lexemes = Backbone.Collection.extend({
	model: myLexicon.ModelClasses.Lexeme,
	url: 'lexemes',
	
	createNewLexeme: function(data) {
		var lexeme = new myLexicon.ModelClasses.Lexeme(data);
		this.add(lexeme);
		return lexeme.cid;
	}
});
