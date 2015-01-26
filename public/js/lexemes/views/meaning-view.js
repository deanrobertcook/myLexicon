myLexicon.ViewClasses.MeaningView = Backbone.View.extend({
	tagName: 'div',
	className: 'meaningContainer',
	
	initialize: function() {
		this.listenTo(this.model, 'change', this.render);
	},
	
	render: function() {
		this.$el.empty();
		this.renderLexeme(this.model.get('targetId'));
		this.renderLexeme(this.model.get('baseId'));
		this.$el.append(this.template(this.model.attributes));
		this.$el.append("ID: " + this.model.get('id'));
		this.renderExamples();
		return this;
	},
	
	renderLexeme: function(lexemeId) {
		var lexeme = myLexicon.Collections.lexemes.get(lexemeId);
		var lexemeView = new myLexicon.ViewClasses.LexemeView({model: lexeme});
		this.$el.append(lexemeView.render().el);
		return this;
	},
	
	renderExamples: function() {
		var examples = this.model.findExamples();
		examples.forEach(function(example) {
			var exampleView = new myLexicon.ViewClasses.ExampleView({model: example});
			this.$el.append(exampleView.render().el);
		}, this);
	},
	
	template: _.template($('#meaningTemplate').html()),
});