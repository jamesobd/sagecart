
App.Views['product-picks-list'] = Backbone.View.extend({
    initialize: function () {
        this.products = app.products;
    },

    events: {
        'remove': 'remove'
    },

    render: function () {
        var products = this.products.getByCategory('Picks');

        products.forEach(function(product) {
            this.$el.append(new App.Views['product-grid-item']({
                model: product,
                gridSize: this.$el.data('grid-size')
            }).render().el);
        }.bind(this));
        return this;
    },

    remove: function (e) {
        e.stopPropagation();
        this.$('> *').trigger('remove');
        Backbone.View.prototype.remove.call(this);
    }
});