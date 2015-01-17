myLexicon.ModelClasses.Meaning = Backbone.Model.extend({
	targetLexemeSynced: false,
	baseLexemeSynced: false,
	
	defaults: {
		frequency: 1,
		dateEntered: (new Date()).toMysqlFormat(),
	},
	
	/**
	 * The first step to persisting a meaning is to first persist it's lexemes,
	 * since the concrete backend IDs are needed to save the meaning. The meaning
	 * binds a listener, pushSelf on the sync status of each lexeme, which, when fired,
	 * updates the IDs of the lexemes.
	 */
	pushLexemes: function() {
		var targetLexeme = myLexicon.Collections.lexemes.get(this.get('targetid'));
		var baseLexeme = myLexicon.Collections.lexemes.get(this.get('baseid'));
		
		this.listenTo(targetLexeme, "sync", this.pushSelf);
		this.listenTo(baseLexeme, "sync", this.pushSelf);
		
		myLexicon.Collections.lexemes.create(targetLexeme);
		myLexicon.Collections.lexemes.create(baseLexeme);
	},
	
	/**
	 * As each of the two lexemes are pushed, the status of the other one is
	 * checked. Once both have been synced (the second trigger to this listener)
	 * then the meaning is permitted to persist itself. 
	 */
	pushSelf: function(lexemePushed) {
		if (lexemePushed.cid === this.get('targetid')) {
			this.targetLexemeSynced = true;
			this.set('targetid', lexemePushed.get('id'));
		}
		
		if (lexemePushed.cid === this.get('baseid')) {
			this.baseLexemeSynced = true;
			this.set('baseid', lexemePushed.get('id'));
		}
		
		if (this.targetLexemeSynced && this.baseLexemeSynced) {
			this.save();
		}
	},
	
	findExamples: function() {
		var examples = [];
		myLexicon.Collections.examples.forEach(function(example) {
			if (example.get('meaningId') === this.get('id')) {
				examples.push(example);
			}
		}, this);
		return examples;
	}
});