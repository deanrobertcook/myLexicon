var AlbumRouter = new (Backbone.Router.extend({
	routes: {
		'': 'index',
		'search/:query(/p:page)': 'search',
	},
	search: function(query, page) {
		console.log(query);
		console.log(page);
	},
	index: function() {
		console.log('index');
	}
}));
Backbone.history.start();

var Album = Backbone.Model.extend({
	urlRoot: 'album-rest',
	initialize: function() {

	},
});

var AlbumView = Backbone.View.extend({
	tagName: "article",
	className: "album",
	template: _.template(
			'<small><%= id %></small>' +
			'<h4><%= title %></h4>' +
			'<h4><%= artist %></h4>'
			),
	initialize: function() {
		this.model.on('remove', this.remove, this);
	},
	events: {
		"dblclick": function () {
			console.log(this.model.get('title'));
		},
	},
	render: function () {
		var attributes = this.model.attributes;
		$(this.el).html(this.template(attributes));
		return this;
	}
});

var AlbumList = Backbone.Collection.extend({
	url: 'album-rest',
	model: Album,
	initialize: function() {
		this.on('remove', this.removeModel);
	},
	removeModel: function(model) {
		model.trigger('remove');
	}
});

var AlbumListView = Backbone.View.extend({
	initialize: function() {
		this.collection.on('add', this.addOne, this);
		this.collection.on('reset', this.addAll, this);
		$("body").append(this.render().el);
	},	
	addOne: function (album) {
		var albumView = new AlbumView({
			model: album,
		});
		this.$el.append(albumView.render().el);
	},
	addAll: function() {
		this.collection.forEach(this.addOne, this);
	},
	render: function () {
		this.addAll();
		return this;
	},
});

var albumList = new AlbumList();
var albumListView = new AlbumListView({
	collection: albumList,
});

albumList.fetch();



