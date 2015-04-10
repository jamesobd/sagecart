App.Views.DefaultPageView = Backbone.View.extend({
    initialize: function(params) {
        // TODO: if the params.page does not exist in App.Templates then show a 404
        this.template = App.Templates['pages/' + params.page];
    },

    events: {
        'remove': 'remove'
    },

    render: function (data) {
        this.$el.html(this.template(data));
        return this;
    }
});