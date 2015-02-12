myLexicon.ModelClasses.Lexeme = Backbone.Model.extend({
	
	initialize: function() {
		this.listenTo(this, 'sync', this.lexemeSynced);
	},
	
	lexemeSynced: function(lexeme, response) {
		this.set('id', response.id);
	},
	
	/**
	 * Finds all meanings associated with this lexeme. Might be better off putting
	 * the inverse of this function into the meanings class
	 */
	findAllMeanings: function(meaningCollection) {
		var meanings = [];
		meaningCollection.forEach(function(meaning) {
			if(meaning.get('targetId') === this.get('id') || 
					meaning.get('baseId') === this.get('id')) {
				meanings.push(meaning);
			}
		}, this);
		return new myLexicon.CollectionClasses.Meanings(meanings);
	},
	
	edit: function(newEntry) {
		var lexemeExists = myLexicon.Collections.lexemes.lexemeExists(
			this.get("language"),
			this.get("type"),
			newEntry
		);
		if (!lexemeExists) {
			this.set("entry", newEntry);
			this.save();
			return true;
		} else {
			return false;
		}
	}
});
