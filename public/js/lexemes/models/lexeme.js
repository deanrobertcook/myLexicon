var app = app || {};

app.Lexeme = Backbone.Model.extend({
	defaults: {
        id: '0',
        language: 'en',
        type: 'verb',
        entry: 'test',
    },
});
