myLexicon.ViewClasses.ExampleView = Backbone.View.extend({
	tagName: 'div',
	className: 'exampleContainer',
	template: _.template($('#exampleTemplate').html()),
	
	events: {
		'click' : 'selectExample',
	},
	
	initialize: function() {
		this.listenTo(this.model, 'change', this.render);
	},
	
	render: function() {
		this.$el.html(this.template(this.model.attributes));
//		this.$el.append("ID: " + this.model.get("id"));
		return this;
	},
	
	selectExample: function() {
		console.log("example selected");
	},
});