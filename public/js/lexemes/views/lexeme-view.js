myLexicon.ViewClasses.LexemeView = Backbone.View.extend({
	tagName: 'div',
	className: 'lexemeContainer',
	template: _.template($('#lexemeTemplate').html()),
	
	events: {
		'click' : 'selectLexeme',
	},
	
	initialize: function() {
		this.listenTo(this.model, 'sync', this.lexemeSynced);
	},
	
	lexemeSynced: function(lexeme, response) {
		this.model.set('id', response.id);
		this.render();
	},
	
	render: function() {
		this.$el.html(this.template(this.model.attributes));
		this.$el.append("ID: " + this.model.get("id"));
		return this;
	},
	
	selectLexeme: function() {
		var id = this.model.get('id');
		myLexicon.router.navigate('lexemes/' + id, {trigger: true});
	},
	
	displayLexeme: function() {
		var meanings = this.model.findAllMeanings(myLexicon.Collections.meanings);
		
		var lexemesMeaningsView = new myLexicon.ViewClasses.MeaningsView(meanings);
		lexemesMeaningsView.render();
	}
});