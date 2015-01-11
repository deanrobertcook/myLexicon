var app = app || {};

app.MeaningsView = Backbone.View.extend({
	tagName: 'div',

	initialize: function(initialMeanings) {
		this.collection = new app.Meanings(initialMeanings);
	},
	
	render: function() {
		this.$el.empty();
		this.collection.each(function(meaning) {
			this.renderMeaning(meaning);
		}, this);
		$("#lexicon").html(this.$el);
	},
	
	renderMeaning: function(meaning) {
		var meaningView = new app.MeaningView({
			model: meaning,
		});
		this.$el.append(meaningView.render().el);
	},
});