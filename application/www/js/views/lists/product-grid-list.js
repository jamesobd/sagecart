App.Views['product-grid-list'] = Backbone.View.extend({
    initialize: function (params) {
        this.products = app.products;
    },

    events: {
        'remove': 'remove'
    },

    render: function () {
        // Get the limit and offset
        var limit = $.getParam('limit') ? Number($.getParam('limit')) : app.defaults.limit;
        var offset = $.getParam('offset') ? Number($.getParam('offset')) : app.defaults.offset;
        var products = this.products.getByURL()

        for (var i = offset; i < products.length && i < offset + limit; i++) {
            this.$el.append(new App.Views['product-grid-item']({
                model: products[i],
                gridSize: this.$el.data('grid-size')
            }).render().el);
        }
        return this;
    },

    remove: function (e) {
        e.stopPropagation();
        this.$('> *').trigger('remove');
        Backbone.View.prototype.remove.call(this);
    }
});