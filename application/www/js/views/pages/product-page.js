App.Views.ProductPage = Backbone.View.extend({
    initialize: function (params) {

    },

    events: {
        'remove': 'remove'
    },

    template1: App.Templates['pages/shop-single-item-v1'],
    template2: App.Templates['pages/shop-single-item-v2'],

    render: function (version) {
        if (version == 'v2') {
            this.$el.html(this.template2(this.model.toJSON()));
        } else {
            this.$el.html(this.template1(this.model.toJSON()));
        }
        return this;
    }
});