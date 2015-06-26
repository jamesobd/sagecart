App.Views.CategoryPage = Backbone.View.extend({
    initialize: function (params) {

    },

    events: {
        'remove': 'remove'
    },

    template: App.Templates['pages/shop-filters-left-3cols'],

    render: function () {
        this.$el.html(this.template());
        return this;
    }
});