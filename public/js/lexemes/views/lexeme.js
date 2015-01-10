var app = app || {};

app.LexemeView = Backbone.View.extend({
	tagName: 'div',
	className: 'lexemeContainer',
	template: _.template($('#lexemeTemplate').html()),
	
	render: function() {
		this.$el.html(this.template(this.model.attributes));
		return this;
	}
});