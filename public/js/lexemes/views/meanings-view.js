myLexicon.ViewClasses.MeaningsView = Backbone.View.extend({
	tagName: 'div',
		
	exampleId: 1,

	initialize: function(collection) {
		this.collection = collection;
		this.listenTo(this.collection, 'add', this.renderMeaning);
	},
	
	render: function() {
		this.$el.empty();
		this.renderInfoBar();
		this.renderPaginationBar();
		this.renderMeanings();
		return this;
	},
	
	renderMeanings: function() {
		this.collection.each(function(meaning) {
			var meaningView = new myLexicon.ViewClasses.MeaningView({
				model: meaning,
			});
			this.$el.append(meaningView.render().el);
		}, this);
		return this;
	},
	
	renderInfoBar: function() {
		this.$el.remove("#meaningsInfo");
		this.$el.prepend(this.infoTemplate({"meaningCount": this.collection.getLength()}));
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
		
		this.$el.find("#meaningsInfo").append(this.paginationTemplate({
			previous: previousPage,
			next: nextPage,
			last: lastPage,
		}));
	},
	
	infoTemplate: _.template(
		'<div id="meaningsInfo">' +
			'#Meanings: <%= meaningCount %>' +
		'</div>'
	), 
	
	paginationTemplate: _.template(
		'<div class="mylexicon-pagination">' +
			'<a href="#meanings/1">First</a>' +
			'<% if (previous !== -1) { %>' +
				'<a href="#meanings/<%= previous %>">Previous</a>' +
			'<% } %>' +
			'<% if (next !== -1) { %>' +
				'<a href="#meanings/<%= next %>">Next</a>' +
			'<% } %>' +
			'<a href="#meanings/<%= last %>">Last</a>' +
		'</div>'
	),
	
});