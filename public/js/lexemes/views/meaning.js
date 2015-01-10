var app = app || {};

app.MeaningView = Backbone.View.extend({
	tagName: 'div',
	className: 'meaningContainer',
	template: _.template($('#meaningTemplate').html()),
	
	render: function() {
		var targetView = new app.LexemeView({
			model: new app.Lexeme(this.model.get('targetLexeme')),
		});
		
		var baseView = new app.LexemeView({
			model: new app.Lexeme(this.model.get('baseLexeme')),
		});
		
		this.$el.append(targetView.render("Target").el);
		this.$el.append(baseView.render("Base").el);
		this.$el.append(this.template(this.model.attributes));
		return this;
	}
});