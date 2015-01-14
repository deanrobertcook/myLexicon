myLexicon.CollectionClasses.Meanings = Backbone.PageableCollection.extend({
	model: myLexicon.ModelClasses.Meaning,
	url: 'meanings',
	
	fullCollection: myLexicon.Collections.meanings,
	mode: "client",
	
	state: {
		pageSize: 6,
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
		meaning.pushLexemes();
	}
});


