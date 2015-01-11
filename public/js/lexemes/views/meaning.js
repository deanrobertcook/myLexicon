var app = app || {};

app.MeaningView = Backbone.View.extend({
	tagName: 'div',
	className: 'meaningContainer',
	template: _.template($('#meaningTemplate').html()),
	
	render: function() {
		this.$el.html(this.template(this.model.attributes));
		return this;
	}
});