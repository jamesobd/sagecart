App.Views.ProductLimitView = Backbone.View.extend({

    events: {
        'remove': 'remove',
        'change #show-page-option': 'setLimit'
    },

    template: App.Templates['product-limit'],

    render: function (limit) {
        this.$el.html(this.template({value: limit}));
        this.$('#product-limit').show();
        return this;
    },

    setLimit: function(e) {
        $.setParam('limit', $(e.target).val());
    }
});