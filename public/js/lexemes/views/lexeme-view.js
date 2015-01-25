myLexicon.ViewClasses.LexemeView = Backbone.View.extend({
	tagName: 'div',
	className: 'lexemeContainer',
	template: _.template($('#lexemeTemplate').html()),
	
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
	
	/**
	 * When a user clicks on a lexeme, redirect them to a new page
	 * which displays only meanings for that lexeme, at 'url/lexemes/id'
	 */
	selectLexeme: function() {
		var id = this.model.get('id');
		myLexicon.router.navigate('lexemes/' + id, {trigger: true});
	},
});