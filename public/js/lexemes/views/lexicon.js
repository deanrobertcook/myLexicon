var app = app || {};

app.LexiconView = Backbone.View.extend({
	tagName: 'div',
	
	infoTemplate: _.template($('#lexiconInfo').html()),
	
	events: {},
	
	initialize: function() {
		this.collection = new app.Lexicon();
		this.collection.fetch({
			reset: true,
		});
		this.render();
		
		this.listenTo(this.collection, 'add', this.renderLexeme);
		this.listenTo(this.collection, 'reset', this.render);
	},
	
	render: function() {
		this.$el.empty();
		this.renderInfoBar();
		this.collection.each(function(meaning) {
			this.renderMeaning(meaning);
		}, this);
		$("#lexicon").append(this.$el);
	},
});