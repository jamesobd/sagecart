App.Views.ProductListView = Backbone.View.extend({
    events: {
        'remove': 'remove',
        'change:pallets': 'updatePalletsToBeAdded'
    },

    tagName: 'ul',

    attributes: {
        class: 'list-unstyled'
    },

    render: function (products) {
        products.forEach(function (product) {
            this.$el.append((new App.Views.ProductListItemView({model: product})).render().el);
        }, this);
        return this;
    },

    renderCart: function (products) {
        products.forEach(function (product) {
            this.$el.append((new App.Views.ProductListCartItemView({model: product})).render().el);
        }, this);
        return this;
    },

    getPalletsToBeAdded: function () {
        return _.reduce(this.$('.pallets'), function (sum, n) {
            return sum + Number(n.innerText);
        }, 0);
    },

    updatePalletsToBeAdded: function () {
        this.trigger('change:pallets-total', this.getPalletsToBeAdded());
    },

    /**
     * Remove all the product list item views and then this page itself
     */
    remove: function () {
        this.$('> *').trigger('remove');
        Backbone.View.prototype.remove.call(this);
    }
});