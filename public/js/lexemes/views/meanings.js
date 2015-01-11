var app = app || {};

app.MeaningsView = Backbone.View.extend({
	tagName: 'div',
	
	infoTemplate: _.template($('#lexiconInfo').html()),
	newMeaningTemplate: _.template($('#newMeaning').html()),
	
	events: {
		"click #addMeaning": "renderNewMeaningForm",
		"click #submitNewMeaning": "createNewMeaning",
	},
	
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
		this.renderInfoBar();
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