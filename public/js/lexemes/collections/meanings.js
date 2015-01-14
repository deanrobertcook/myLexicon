myLexicon.CollectionClasses.Meanings = Backbone.PageableCollection.extend({
	model: myLexicon.ModelClasses.Meaning,
	url: 'meanings',
	
	mode: "client",
	
	previouslyEnteredLexemeType: "noun",
	
	state: {
		pageSize: 25,
	},
	
	createMeaning: function (formData) {
		var targetData = {
			"language": "de", //Change this to default to user's selection
			"type": formData.targetType,
			"entry": formData.targetEntry,
		};

		var baseData = {
			"language": "en", //Change this to default to user's selection
			"type": formData.baseType,
			"entry": formData.baseEntry,
		};

		var targetcid = myLexicon.Collections.lexemes.createNewLexeme(targetData);
		var basecid = myLexicon.Collections.lexemes.createNewLexeme(baseData);

		var meaning = new this.model({
			"targetid": targetcid,
			"baseid": basecid
		});

		this.fullCollection.add(meaning);
		this.setPreviouslyEnteredLexemeType(formData.targetType);
		meaning.pushLexemes();
	},
	
	getLength: function() {
		return this.fullCollection.length;
	},
	
	setPreviouslyEnteredLexemeType: function(type) {
		this.fullCollection.previouslyEnteredLexemeType = type;
	}, 
	
	getPreviouslyEnteredLexemeType: function() {
		if (this.fullCollection.previouslyEnteredLexemeType) {
			return this.fullCollection.previouslyEnteredLexemeType;
		} else {
			return "noun";
		}
	}
});


