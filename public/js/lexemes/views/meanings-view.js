myLexicon.ViewClasses.MeaningsView = Backbone.View.extend({
	tagName: 'div',
	
	infoTemplate: _.template($('#meaningsInfo').html()),
	paginationTemplate: _.template($('#paginationTemplate').html()),
	
	exampleId: 1,

	initialize: function(collection) {
		this.collection = collection;
		this.listenTo(this.collection, 'add', this.renderMeaning);
	},
	
	render: function() {
		this.$el.empty();
		this.renderInfoBar();
		this.collection.each(function(meaning) {
			this.renderMeaning(meaning);
		}, this);
		this.renderPaginationBar();
		return this;
	},
	
	renderInfoBar: function() {
		this.$el.remove("#meaningsInfo");
		this.$el.prepend(this.infoTemplate({"meaningCount": this.collection.getLength()}));
		return this;
	},
	
	renderPaginationBar: function() {
		var currentPage = this.collection.state.currentPage;
		var previousPage = -1;
		if (this.collection.hasPreviousPage()) {
			previousPage = currentPage - 1;
		}
		
		var lastPage = this.collection.state.lastPage;
		var nextPage = -1;
		if (this.collection.hasNextPage()) {
			nextPage = currentPage + 1;
		}
		
		this.$el.prepend(this.paginationTemplate({
			previous: previousPage,
			next: nextPage,
			last: lastPage,
		}));
		return this;
	},

	renderMeaning: function(meaning) {
		var meaningView = new myLexicon.ViewClasses.MeaningView({
			model: meaning,
		});
		this.$el.append(meaningView.render().el);
	},
});