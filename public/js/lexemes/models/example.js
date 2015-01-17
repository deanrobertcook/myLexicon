myLexicon.ModelClasses.Example = Backbone.Model.extend({
	defaults: {
		exampleTarget: "",
		exampleBase: "",
	},
	
	updateMeaningId: function(meaning, response) {
		this.set("meaningId", response.id);
		console.log(this);
		this.save();
	}
});
