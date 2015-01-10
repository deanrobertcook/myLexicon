var app = app || {};

app.MeaningsView = Backbone.View.extend({
	tagName: 'div',
	
	infoTemplate: _.template($('#lexiconInfo').html()),
	newMeaningTemplate: _.template($('#newMeaning').html()),
	
	events: {
		"click #addMeaning": "renderNewMeaningForm",
		"click #submitNewMeaning": "createNewMeaning",
	},
	
	initialize: function(initialMeanings) {
		if (initialMeanings) {
			this.collection = new app.Meanings(initialMeanings);
		} else {
			this.collection = new app.Meanings();
			this.collection.fetch({
				reset: true,
			});
		}
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
	
	renderNewMeaningForm: function() {
		$("#newMeaning").remove();
		$("div.lexiconInfo").after(this.newMeaningTemplate());
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
	},
	
	createNewMeaning: function(e) {
		e.preventDefault();
		var formData = {};
		$('#newMeaning div').children("input").each(function(index, element) {
			formData[element.id] = element.value; 
		});
		
		var targetLexeme = new app.Lexeme({
			"language": "de", //Change this to default to user's selection
			"type": formData.targetType,
			"entry": formData.targetEntry,
		});
		
		var baseLexeme = new app.Lexeme({
			"language": "en", //Change this to default to user's selection
			"type": formData.baseType,
			"entry": formData.baseEntry,
		});
	},
});