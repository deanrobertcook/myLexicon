var app = app || {};

app.Lexeme = Backbone.Model.extend({
	defaults: {
        id: '0',
        language: 'en',
		target: false,
        type: 'verb',
        entry: 'test',
    }
});
