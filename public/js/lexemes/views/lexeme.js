var app = app || {};

app.LexemeView = Backbone.View.extend({
	tagName: 'div',
	className: 'lexemeContainer',
	template: _.template($('#lexemeTemplate').html()),
	
	events: {
		'click' : 'selectLexeme',
	},
	
	render: function() {
		this.$el.html(this.template(this.model.attributes));
		return this;
	},
	
	selectLexeme: function() {
		var id = this.model.get('id');
		var meanings = app.meaningsView.findMeanings(this.model);
		app.Router.navigate('lexeme/' + id);
		app.meaningsView.remove();
		app.meaningsView = new app.MeaningsView(meanings);
	}
});