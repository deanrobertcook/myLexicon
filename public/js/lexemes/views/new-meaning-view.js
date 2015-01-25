myLexicon.ViewClasses.NewMeaningView = Backbone.View.extend({
	tagName: "div",
	id: "newMeaning",
	exampleId: 1,
	
	events: {
		"click #submitNewMeaning": "submitNewMeaning",
		"click #anotherExample": "anotherExample",
		"click .clearExample": "clearExample",
	},
	
	render: function() {
		this.$el.html(this.meaningForm());
		this.$el.find("#anotherExample").before(this.exampleSubForm({exampleId: this.exampleId}));
		this.exampleId++;
		$("#lexicon").html(this.$el);
		return this;
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
		myLexicon.Collections.meanings.createMeaning(formData);
//		$("#newMeaning").find(".example-input").val(null);
//		this.toggleMeaningForm();
	},
	
	meaningForm: _.template(
		'<form action="#">' +
			'<div>' +
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

				'<label for="targetEntry">Target Entry: </label>' +
				'<input id="targetEntry" class="lexeme-input" type="text" />' +

				'<label for="baseEntry">Base Entry: </label>' +
				'<input id="baseEntry" class="lexeme-input" type="text" />' +	
			'</div>' +
			
			'<button id="submitNewMeaning">Submit Meaning</button>' +
			'<button id="anotherExample">Another Example</button>' +
		'</form>'
	),
	
	exampleSubForm: _.template(
		'<div class="newExample">' +
			'<label for="exampleTarget<%= exampleId %>">Example Target: </label>' +
			'<input id="exampleTarget<%= exampleId %>" class="lexeme-input example-input" type="text" />' +

			'<label for="exampleBase<%= exampleId %>">Example Base: </label>' +
			'<input id="exampleBase<%= exampleId %>" class="lexeme-input example-input" type="text" />' +
			'<button class="clearExample">Clear Example</button>' +
		'</div>'
	),
});