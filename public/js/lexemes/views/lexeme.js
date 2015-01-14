var app = app || {};

app.LexemeView = Backbone.View.extend({
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
		app.Router.navigate('lexemes/' + id, {trigger: true});
	},
	
	displayLexeme: function() {
		var meanings = [];
		app.meaningsView.collection.forEach(function(meaning) {
			if(meaning.get('targetid') === this.model.get('id') || 
					meaning.get('baseid') === this.model.get('id')) {
				meanings.push(meaning);
			}
		}, this);
		
		if (app.lexemeMeaningsView) {
			app.lexemeMeaningsView.remove();
		}
		app.lexemeMeaningsView = new app.MeaningsView(meanings);
		app.lexemeMeaningsView.render();
	}
});