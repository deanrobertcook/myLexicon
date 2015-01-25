myLexicon.ViewClasses.NavigationBar = Backbone.View.extend({
	tagName: "div",
	id: "navigationBar",
	
	events: {
		"click #goToLexicon": "goToLexicon", 
		"click #newMeaningButton": "newMeaningButton", 
	},
	
	render: function() {
		this.$el.html(this.template());
		return this;
	},
	
	goToLexicon: function() {
		myLexicon.router.navigate('meanings', {trigger: true});
	},
	
	newMeaningButton: function() {
		myLexicon.router.navigate('new-meaning', {trigger: true});	
	},
	
	template: _.template(
		'<button id="goToLexicon">My Lexicon</button>' +
		'<button id="newMeaningButton">Add New Meaning</button>'
	),
});