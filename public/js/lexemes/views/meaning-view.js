myLexicon.ViewClasses.MeaningView = Backbone.View.extend({
	tagName: 'div',
	className: 'meaningContainer',
	template: _.template($('#meaningTemplate').html()),
	
	initialize: function() {
		var targetLexeme = myLexicon.Collections.lexemes.findLexeme(this.model.get('targetid'));
		var baseLexeme = myLexicon.Collections.lexemes.findLexeme(this.model.get('baseid'));
		
		this.listenTo(targetLexeme, 'change:[id]', this.changedLexeme);
		this.listenTo(baseLexeme, 'change:[id]', this.changedLexeme);
		this.listenTo(this.model, 'sync', this.meaningSynced);
	},
	
	meaningSynced: function(meaning, response) {
		this.model.set('id', response.id);
		this.render();
	},
	
	render: function() {
		this.$el.empty();
		this.renderLexeme(this.model.get('targetid'));
		this.renderLexeme(this.model.get('baseid'));
		this.$el.append(this.template(this.model.attributes));
		this.$el.append("ID: " + this.model.get('id'));
		return this;
	},
	
	renderLexeme: function(lexemeId) {
		var lexeme = myLexicon.Collections.lexemes.findLexeme(lexemeId);
		var lexemeView = new myLexicon.ViewClasses.LexemeView({model: lexeme});
		this.$el.append(lexemeView.render().el);
		return this;
	},
});