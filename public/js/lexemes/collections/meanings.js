myLexicon.CollectionClasses.Meanings = Backbone.PageableCollection.extend({
	model: myLexicon.ModelClasses.Meaning,
	url: 'meanings',
	
	mode: "client",
	
	previouslyEnteredLexemeType: "noun",
	
	state: {
		pageSize: 25,
	},
	
	createMeaning: function (formData) {	
		var targetCid = this.createLexeme(formData, true);
		var baseCid = this.createLexeme(formData, false);
		
		var meaning = new this.model({
			"targetId": targetCid,
			"baseId": baseCid,
			"dateEntered" : (new Date()).toMysqlFormat(),
		});
		
		this.createExample(formData, meaning);

		this.fullCollection.add(meaning);
		this.setPreviouslyEnteredLexemeType(formData.targetType);
		meaning.pushLexemes();
	},
	
	createLexeme: function(formData, isTarget) {
		var type = isTarget ? "target" : "base";
		var language = isTarget ? "de" : "en"; //Change this to default to user's selection
		var lexemeData = {
			"language": language, 
			"type": formData[type + "Type"],
			"entry": formData[type + "Entry"],
		};
		var lexemecid = myLexicon.Collections.lexemes.createNewLexeme(lexemeData);
		return lexemecid;
	},
	
	createExample: function(formData, meaning) {
		var exampleId = 1;
		var examplesData = [];
		var formKeys = Object.keys(formData);
		
		while (formData["exampleTarget" + exampleId]) {
			var exampleDatum = {
				exampleTarget: formData["exampleTarget" + exampleId],
				exampleBase: formData["exampleBase" + exampleId],
			};
			examplesData.push(exampleDatum);
			exampleId++;
		}
		
		myLexicon.Collections.examples.createNewExamples(examplesData, meaning);
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


