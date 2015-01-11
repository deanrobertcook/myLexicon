var app = app || {};

app.MeaningView = Backbone.View.extend({
	tagName: 'div',
	className: 'meaningContainer',
	template: _.template($('#meaningTemplate').html()),
	
	render: function() {
		var targetLexeme = app.lexemesView.findLexeme(this.model.get('targetid'));
		var baseLexeme = app.lexemesView.findLexeme(this.model.get('baseid'));
		
		var targetView = new app.LexemeView({model: targetLexeme});
		var baseView = new app.LexemeView({model: baseLexeme});
		
		this.$el.html(targetView.render().el);
		this.$el.append(baseView.render().el);
		this.$el.append(this.template(this.model.attributes));
		return this;
	}
});