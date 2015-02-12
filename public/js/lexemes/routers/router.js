myLexicon.RouterClasses.Router = Backbone.Router.extend({
	applicationAnchor: $("#lexicon"),
	
	routes: {
		'': "default",
		'lexemes/:id': "displayLexeme",
		'meanings': "meanings",
		'meanings/:pageNo': "meaningsPage",
		'new-meaning': "newMeaning",
	},
	
	default: function () {
		var collection = myLexicon.Collections.meanings;
		collection.comparator = 'id';
		collection.sort();
		
//		console.log(collection.length);
		
		var meanings = allMeanings;
		meanings.sort(function(a, b) {
			if (a.id > b.id) {
				return 1;
			}
			if (a.id < b.id) {
				return -1;
			}
			
			return 0;
		});
//		console.log(meanings);
		var numberDupped = 0;
		for (var i = 0; i < meanings.length; i++) {
			if (i > 0) {
				if (meanings[i].id === meanings[i-1].id) {
					numberDupped++;
				}
			}
		}
		console.log(numberDupped);
	},
	
	/**
	 * For a given lexeme, all associated meanings are displayed from the main
	 * collection
	 * @param {int} id
	 */
	displayLexeme: function(id) {
		var navigationBar = new myLexicon.ViewClasses.NavigationBar();
		this.applicationAnchor.html(navigationBar.render().el);
		
		var lexeme = myLexicon.Collections.lexemes.get(id);
		var allMeanings = myLexicon.Collections.meanings;
		var meanings = lexeme.findAllMeanings(allMeanings);
		var lexemesMeaningsView = new myLexicon.ViewClasses.MeaningsView(meanings);
		this.applicationAnchor.append(lexemesMeaningsView.render().el);
	},
	
	newMeaning: function() {
		var navigationBar = new myLexicon.ViewClasses.NavigationBar();
		this.applicationAnchor.html(navigationBar.render().el);
		
		var newMeaningView = new myLexicon.ViewClasses.NewMeaningView();
		this.applicationAnchor.append(newMeaningView.render().el);
	},
	
	meanings: function () {
		this.meaningsPage(0);
	},
	
	meaningsPage: function(pageNo) {
		var navigationBar = new myLexicon.ViewClasses.NavigationBar();
		this.applicationAnchor.html(navigationBar.render().el);
		
		var meaningsView = new myLexicon.ViewClasses.MeaningsView(myLexicon.Collections.meanings);
		this.applicationAnchor.append(meaningsView.renderPage(pageNo, 5).el);
	}
}); 

