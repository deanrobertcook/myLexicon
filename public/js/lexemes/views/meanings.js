var app = app || {};

app.MeaningsView = Backbone.View.extend({
	tagName: 'div',
	
	newMeaningFormTemplate: _.template($('#newMeaning').html()),
	infoTemplate: _.template($('#meaningsInfo').html()),
	
	events: {
		"click #addMeaning": "renderNewMeaningForm",
		"click #submitNewMeaning": "createNewMeaning",
	},


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
	
	renderNewMeaningForm: function() {
		$("#newMeaning").remove();
		$("#meaningsInfo").after(this.newMeaningFormTemplate());
	},
	
	createNewMeaning: function(e) {
		e.preventDefault();
		var formData = {};
		$('#newMeaning div').children("input").each(function(index, element) {
				formData[element.id] = element.value; 
		});
		
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
		
		app.lexemesView.createNewLexeme(targetData);
		app.lexemesView.createNewLexeme(baseData);
	},


});