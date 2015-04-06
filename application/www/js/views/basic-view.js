App.Views.BasicView = Backbone.View.extend({
    initialize: function(params) {
        this.template = params.template;
    },

    render: function () {
        this.$el.html(this.template());
        return this;
    }
});