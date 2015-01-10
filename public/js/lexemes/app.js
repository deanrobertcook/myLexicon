var app = app || {};

$(function() {
	var lexemes = [
		{"id":"1", "language":"de", "type":"verb", "entry":"kaufen"},
		{"id":"2", "language":"en", "type":"verb", "entry":"to buy"},
		{"id":"3", "language":"en", "type":"verb", "entry":"to purchase"},
		{"id":"4", "language":"de", "type":"verb", "entry":"laufen"},
		{"id":"5", "language":"en", "type":"verb", "entry":"to run"},
	];
	
	new app.LexiconView(lexemes);
});