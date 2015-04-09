App.Views.BasicView = Backbone.View.extend({
    initialize: function(params) {
        this.template = params.template;
    },

    events: {
        'remove': 'remove'
    },

    render: function (data) {
        this.$el.html(this.template(data));
        return this;
    }
});