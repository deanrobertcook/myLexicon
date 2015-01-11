var app = app || {};

app.MeaningsView = Backbone.View.extend({
	tagName: 'div',

	initialize: function() {
		this.collection = new app.Meanings();
		this.collection.fetch({
			reset: true,
			success: function() {
				app.Router.meaningsLoaded = true;
			},
		});
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