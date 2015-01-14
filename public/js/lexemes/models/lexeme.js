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
			if(meaning.get('targetid') === this.get('id') || 
					meaning.get('baseid') === this.get('id')) {
				meanings.push(meaning);
			}
		}, this);
		return new myLexicon.CollectionClasses.Meanings(meanings);
	}
});
