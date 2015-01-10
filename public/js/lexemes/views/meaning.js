var app = app || {};

app.MeaningView = Backbone.View.extend({
	tagName: 'div',
	className: 'meaningContainer',
	template: _.template($('#meaningTemplate').html()),
	
	render: function() {
		var targetLexeme = this.model.get('targetLexeme');
		targetLexeme.target = true;
		var targetView = new app.LexemeView({
			model: new app.Lexeme(targetLexeme),
		});
		
		var baseLexeme = this.model.get('baseLexeme');
		baseLexeme.target = false;
		var baseView = new app.LexemeView({
			model: new app.Lexeme(baseLexeme),
		});
		
		this.$el.append(targetView.render().el);
		this.$el.append(baseView.render().el);
		this.$el.append(this.template(this.model.attributes));
		return this;
	}
});