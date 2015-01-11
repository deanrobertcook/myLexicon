var app = app || {};

app.MeaningsView = Backbone.View.extend({
	tagName: 'div',
	
	newMeaningFormTemplate: _.template($('#newMeaning').html()),
	infoTemplate: _.template($('#meaningsInfo').html()),

	initialize: function(initialMeanings) {
		this.collection = new app.Meanings(initialMeanings);
	},
	
	render: function() {
		this.$el.empty();
		this.renderInfoBar();
		this.collection.each(function(meaning) {
			this.renderMeaning(meaning);
		}, this);
		$("#lexicon").html(this.$el);
	},
	
	renderInfoBar: function() {
		this.$el.append(this.infoTemplate({"meaningCount": this.collection.length}));
		return this;
	},

	renderMeaning: function(meaning) {
		var meaningView = new app.MeaningView({
			model: meaning,
		});
		this.$el.append(meaningView.render().el);
	},
});