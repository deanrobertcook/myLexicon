var app = app || {};

app.LexiconView = Backbone.View.extend({
	el: '#lexicon',
	
	infoTemplate: _.template($('#lexiconInfo').html()),
	
	initialize: function(initialMeanings) {
		if (initialMeanings) {
			this.collection = new app.Lexicon(initialMeanings);
		} else {
			this.collection = new app.Lexicon();
			this.collection.fetch({
				reset: true,
			});
		}
		this.render();
		
		this.listenTo(this.collection, 'add', this.renderLexeme);
		this.listenTo(this.collection, 'reset', this.render);
	},
	
	infoBar: function() {
		this.$el.append(this.infoTemplate({"meaningCount": this.collection.length}));
	},
	
	render: function() {
		this.$el.empty();
		this.infoBar();
		this.collection.each(function(meaning) {
			this.renderMeaning(meaning);
		}, this);
	},
	
	renderMeaning: function(meaning) {
		var meaningView = new app.MeaningView({
			model: meaning,
		});
		this.$el.append(meaningView.render().el);
	},
	
	findMeanings: function(lexeme) {
		var meanings = [];
		this.collection.forEach(function(meaning) {
			if (lexeme.get('target')) {
				if (meaning.get('targetLexeme').id === lexeme.get('id')) {
					meanings.push(meaning);
				}
			} else {
				if (meaning.get('baseLexeme').id === lexeme.get('id')) {
					meanings.push(meaning);
				}
			}
		});
		return meanings;
	}
});