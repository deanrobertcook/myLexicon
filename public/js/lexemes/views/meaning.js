var app = app || {};

app.MeaningView = Backbone.View.extend({
	tagName: 'div',
	className: 'meaningContainer',
	template: _.template($('#meaningTemplate').html()),
	
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
	}
});