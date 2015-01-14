myLexicon.ModelClasses.Meaning = Backbone.Model.extend({
	targetLexemeSynced: false,
	baseLexemeSynced: false,
	
	defaults: {
		frequency: 1,
		dateEntered: (new Date()).toMysqlFormat(),
	},
	
	pushLexemes: function() {
		var targetLexeme = myLexicon.Collections.lexemes.get(this.get('targetid'));
		var baseLexeme = myLexicon.Collections.lexemes.get(this.get('baseid'));
		
		this.listenTo(targetLexeme, "sync", this.pushSelf);
		this.listenTo(baseLexeme, "sync", this.pushSelf);
		
		myLexicon.Collections.lexemes.create(targetLexeme);
		myLexicon.Collections.lexemes.create(baseLexeme);
	},
	
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
			this.collection.create(this);
		}
	}
});