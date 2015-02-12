myLexicon.ViewClasses.LexemeView = Backbone.View.extend({
	tagName: 'div',
	className: 'lexemeInfo',
	
	events: {
		'dblclick' : 'selectLexeme',
		'click' : 'editLexeme',
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
	
	editLexeme: function() {
		var $entryElement = this.$el.find(".lexeme-entry");
		var originalValue = $entryElement.html();
		$entryElement.attr("contenteditable", true); 
		$entryElement.focus();
		
		$entryElement.off("focusout");
		var instance = this;
		$entryElement.focusout(function() {
			var newValue = $entryElement.html();
			if (newValue !== originalValue) {
				var editSuccessful = instance.model.edit(newValue);
				if (!editSuccessful) {
					alert("That lexeme already exists")
					$entryElement.html(originalValue);
				}
			}
		});	
	},
	
	template: _.template(
		'<div class="lexeme-language"><%= language %></div>' +
		'<div class="lexeme-type"><%= type %></div>' +
		'<div class="lexeme-entry"><%= entry %></div>'
	),
});