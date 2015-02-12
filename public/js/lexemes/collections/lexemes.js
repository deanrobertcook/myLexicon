myLexicon.CollectionClasses.Lexemes = Backbone.Collection.extend({
	model: myLexicon.ModelClasses.Lexeme,
	url: 'lexemes',
	
	createNewLexeme: function(data) {
		var lexeme = new this.model(data);
		this.add(lexeme);
		return lexeme.cid;
	},
	
	lexemeExists: function(language, type, entry) {
		var match = false;
		this.each(function(lexeme) {
			if (lexeme.get("language") === language &&
				lexeme.get("type") === type &&
				lexeme.get("entry") === entry) {
				match = true;
			}
		});
		return match;
	}
});
