myLexicon.ViewClasses.NewMeaningView = Backbone.View.extend({
	tagName: "div",
	exampleId: 1,
	recentMeanings: null,
	
	events: {
		"click #submitNewMeaning": "submitNewMeaning",
		"click #anotherExample": "anotherExample",
		"click .clearExample": "clearExample",
	},
	
	initialize: function() {
		this.recentMeanings = myLexicon.Collections.meanings.getRecentlyCreatedMeanings(5);
	},
	
	render: function() {
		this.$el.html(this.meaningForm());
		this.$el.find("#anotherExample").before(this.exampleSubForm({exampleId: this.exampleId}));
		this.exampleId++;
		this.renderRecentMeanings();
		$("#targetEntry").focus();
		return this;
	},
	
	renderRecentMeanings: function() {
		this.$el.find(".meaningInfo").parent().empty();
		var recentMeaningsView = new myLexicon.ViewClasses.MeaningsView(this.recentMeanings);
		this.$el.append(recentMeaningsView.renderMeanings().el);
		this.$el.find(".meaningInfo").first().before("<h4>Recently Added Meanings</h4>");
	},
	
	setWidth: function(elementWidth) {
		this.$el.css({width: elementWidth});
	},
	
	anotherExample: function(e) {
		e.preventDefault();
		$("#anotherExample").before(this.exampleSubForm({exampleId: this.exampleId}));
		this.exampleId++;
	},
	
	clearExample: function(e) {
		e.preventDefault();
		$("#newMeaning").find(".example-input").val(null);
	},
	
	submitNewMeaning: function(e) {
		e.preventDefault();
		var form = $(e.currentTarget).parents("form")[0];
		var formData = {};
		$(form).find(".lexeme-input").each(function(index, element) {
			formData[element.id] = element.value; 
		});
		console.log(formData);
		var meaning = myLexicon.Collections.meanings.createMeaning(formData);
		this.updateRecentMeanings(meaning);
	},
	
	updateRecentMeanings: function(meaning) {
		this.recentMeanings.unshift(meaning);
		this.recentMeanings.pop();
		this.renderRecentMeanings();
	},
	
	meaningForm: _.template(
		'<div id="newMeaning">' +
		'<h4>New Meaning</h4>' +
		'<form action="#">' +
			'<div id="meaningForm">' +
				'<div id="types">' +
					'<label for="targetType">Target Type: </label>' +
					'<select id="targetType" class="lexeme-input">' +
						'<option value="noun">Noun</option>' +
						'<option value="verb">Verb</option>' +
						'<option value="adjective/adverb">Adjective/Adverb</option>' +
						'<option value="preposition">Preposition</option>' +
					'</select>' +

					'<label for="baseType">Base Type: </label>' +
					'<select id="baseType" class="lexeme-input">' +
						'<option value="noun">Noun</option>' +
						'<option value="verb">Verb</option>' +
						'<option value="adjective/adverb">Adjective/Adverb</option>' +
						'<option value="preposition">Preposition</option>' +
					'</select>' +
				'</div>' +
		
				'<div id="entries">' +
					'<label for="targetEntry">Target Entry: </label>' +
					'<input id="targetEntry" class="lexeme-input" type="text" />' +

					'<label for="baseEntry">Base Entry: </label>' +
					'<input id="baseEntry" class="lexeme-input" type="text" />' +	
				'</div>' +
				'<button id="submitNewMeaning">Submit Meaning</button>' +
			'</div>' +
			
			'<button id="anotherExample" class="exampleButtons">Another Example</button>' +
			'<button class="clearExample exampleButtons">Clear Examples</button>' +
		'</form>' +
		'</div>'
	),
	
	exampleSubForm: _.template(
		'<div class="newExample">' +
			'<label for="exampleTarget<%= exampleId %>">Example Target: </label>' +
			'<input id="exampleTarget<%= exampleId %>" class="lexeme-input example-input" type="text" />' +

			'<label for="exampleBase<%= exampleId %>">Example Base: </label>' +
			'<input id="exampleBase<%= exampleId %>" class="lexeme-input example-input" type="text" />' +
		'</div>'
	),
});