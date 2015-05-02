App.Views.AutoRoutePage = Backbone.View.extend({
    initialize: function (params) {
        if (App.Templates['pages/' + params.page]) {
            this.template = App.Templates['pages/' + params.page];
            this.$el.addClass(params.page + '-page');
        } else {
            // TODO: if the params.page does not exist in App.Templates then show a 404 page
            this.template = function () {return 'Page Not Found'};
        }
    },

    events: {
        'remove': 'remove'
    },

    render: function () {
        this.$el.html(this.template());
        return this;
    }
});