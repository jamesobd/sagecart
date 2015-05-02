App.Views['product-grid-list'] = Backbone.View.extend({
    initialize: function (params) {
        this.products = app.products;
    },

    attributes: {
        class: 'row'
    },

    events: {
        'remove': 'remove'
    },

    render: function () {
        this.products.each(function (product) {
            this.$el.append(new App.Views['product-grid-item']({
                model: product,
                gridSize: this.$el.attr('data-grid-size')
            }).render().el);
        }, this);
        return this;
    },

    remove: function (e) {
        e.stopPropagation();
        this.$('> *').trigger('remove');
        Backbone.View.prototype.remove.call(this);
    }
});