myLexicon.ViewClasses.MeaningsView = Backbone.View.extend({
	tagName: 'div',
	exampleId: 1,

	initialize: function(collection) {
		this.collection = collection;
		this.listenTo(this.collection, 'add', this.renderMeaning);
	},
	
	renderPage: function(pageNo, pageSize) {
		this.$el.empty();
		this.renderInfoBar();
		this.renderMeanings(pageNo, pageSize);
		return this;
	},
	
	renderMeanings: function(pageNo, pageSize) {
		if (!pageNo) {
			pageNo = 0;
		}
		
		if (!pageSize) {
			pageSize = 5;
		}
		
		var firstModel = pageNo * pageSize;
		
		for (var i = 0; i < pageSize; i++) {
			if (this.collection.at(i + firstModel)) {
				var meaningView = new myLexicon.ViewClasses.MeaningView({
				model: this.collection.at(i + firstModel),
				});
			} else {
				break;
			}
			this.$el.append(meaningView.render().el);
		}
		
		return this;
	},
	
	renderInfoBar: function() {
		this.$el.remove("#meaningsInfo");
		this.$el.prepend(this.infoTemplate({"meaningCount": this.collection.length}));
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