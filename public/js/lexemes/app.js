var app = app || {};

$(function() {
	var lexemes = [
		{"id":"1", "language":"de", "type":"verb", "entry":"kaufen"},
		{"id":"2", "language":"en", "type":"verb", "entry":"to buy"},
		{"id":"3", "language":"en", "type":"verb", "entry":"to purchase"},
		{"id":"4", "language":"de", "type":"verb", "entry":"laufen"},
		{"id":"5", "language":"en", "type":"verb", "entry":"to run"},
	];
	
	var meanings = [
		{
			"id": "1",
			"frequency":"1",
			"targetLexeme": {
				"id":"1",
				"language":"de",
				"type":"verb",
				"entry":"kaufen",
			},
			"baseLexeme" : {
				"id":"3",
				"language":"de",
				"type":"verb",
				"entry":"to purchase",
			}	
		},
		{
			"id": "2",
			"frequency":"2",
			"targetLexeme": {
				"id":"1",
				"language":"de",
				"type":"verb",
				"entry":"kaufen",
			},
			"baseLexeme" : {
				"id":"2",
				"language":"de",
				"type":"verb",
				"entry":"to buy",
			}	
		},
		{
			"id": "3",
			"frequency":"2",
			"targetLexeme": {
				"id":"4",
				"language":"de",
				"type":"verb",
				"entry":"laufen",
			},
			"baseLexeme" : {
				"id":"5",
				"language":"de",
				"type":"verb",
				"entry":"to run",
			}	
		},
	];
	
	app.meaningsView = new app.MeaningsView();
});