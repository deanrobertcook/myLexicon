myLexicon.CollectionClasses.Examples = Backbone.Collection.extend({
	model: myLexicon.ModelClasses.Example,
	url: 'examples',
	
	createNewExamples: function(examplesData, meaning) {
		examplesData.forEach(function(exampleData) {
			var example = new this.model(exampleData);
			example.listenTo(meaning, "sync", example.updateMeaningId);
			this.add(example);
		}, this);
	}
});
