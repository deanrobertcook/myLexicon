var app = app || {};

app.MeaningView = Backbone.View.extend({
	tagName: 'div',
	className: 'meaningContainer',
	template: _.template($('#meaningTemplate').html()),
	
	initialize: function() {
		var targetLexeme = app.lexemesView.findLexeme(this.model.get('targetid'));
		var baseLexeme = app.lexemesView.findLexeme(this.model.get('baseid'));
		
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
		return this;
	},
	
	renderLexeme: function(lexemeId) {
		var lexeme = app.lexemesView.findLexeme(lexemeId);
		var lexemeView = new app.LexemeView({model: lexeme});
		this.$el.append(lexemeView.render().el);
		return this;
	},
	
	changedLexeme: function() {
		console.log("Got the lexeme change!!");
	}
});