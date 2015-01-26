myLexicon.ViewClasses.LexemeView = Backbone.View.extend({
	tagName: 'div',
	className: 'lexemeInfo',
	
	events: {
		'click' : 'selectLexeme',
	},
	
	initialize: function() {
		this.listenTo(this.model, 'change', this.render);
	},
	
	render: function() {
		this.$el.html(this.template(this.model.attributes));
//		this.$el.append("ID: " + this.model.get("id"));
		return this;
	},
	
	selectLexeme: function() {
		var id = this.model.get('id');
		myLexicon.router.navigate('lexemes/' + id, {trigger: true});
	},
	
	template: _.template(
		'<div class="lexeme-language"><%= language %></div>' +
		'<div class="lexeme-type"><%= type %></div>' +
		'<div class="lexeme-entry"><%= entry %></div>'
	),
});