var app = app || {};

app.MeaningsView = Backbone.View.extend({
	tagName: 'div',
	
	newMeaningFormTemplate: _.template($('#newMeaning').html()),
	infoTemplate: _.template($('#meaningsInfo').html()),
	
	events: {
		"click #toggleMeaningForm": "toggleMeaningForm",
		"click #submitNewMeaning": "createNewMeaning",
	},


	initialize: function(initialMeanings) {
		this.collection = new app.Meanings(initialMeanings);
		
		this.listenTo(this.collection, 'add', this.renderMeaning);
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
		this.$el.remove("#meaningsInfo");
		this.$el.prepend(this.infoTemplate({"meaningCount": this.collection.length}));
		return this;
	},

	renderMeaning: function(meaning) {
		var meaningView = new app.MeaningView({
			model: meaning,
		});
		this.$el.append(meaningView.render().el);
	},
	
	toggleMeaningForm: function() {
		if ($("#newMeaning").length) {
			$("#newMeaning").remove();
			$("#toggleMeaningForm").text("Add Meaning");
		} else {
			$("#toggleMeaningForm").text("Hide Form");
			$("#meaningsInfo").after(this.newMeaningFormTemplate());
		}
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
		
		var targetcid = app.lexemesView.createNewLexeme(targetData);
		var basecid = app.lexemesView.createNewLexeme(baseData);
		
		var meaning = new app.Meaning({
			"targetid": targetcid,
			"baseid": basecid
		});
		
		this.collection.add(meaning);
		meaning.pushLexemes();
		this.toggleMeaningForm();
	},
});