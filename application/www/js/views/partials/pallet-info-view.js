App.Views.PalletInfoView = Backbone.View.extend({
    initialize: function (options) {
        this.products = options.products;
        this.productListView = options.productListView;
        this.listenTo(this.collection, 'change:_Quantity', this.updatePalletsInCart);
        this.listenTo(this.productListView, 'change:pallets-total', this.updatePalletsToBeAdded);
    },

    attributes: {
        'class': 'row'
    },
    events: {
        'remove': 'remove',
        'click .add-all-to-cart': 'addToCart'
    },

    template: App.Templates['pallet-info'],

    render: function () {
        var palletsInCart = this.collection.getPalletsInCart().toFixed(2);
        this.$el.html(this.template({palletsInCart: palletsInCart}));
        return this;
    },

    updatePalletsInCart: function () {
        var palletsInCart = this.collection.getPalletsInCart().toFixed(2);
        this.$('.pallets-in-cart').html(palletsInCart);
        this.$('.new-total-pallets').html(palletsInCart + this.productListView.getPalletsToBeAdded());
    },

    updatePalletsToBeAdded: function(palletsToAdd) {
        this.$('.pallets-to-add').html(String(palletsToAdd.toFixed(2)));
        this.$('.new-total-pallets').html((palletsToAdd + this.collection.getPalletsInCart()).toFixed(2));
    },

    /**
     * Triggers all items to save their product model
     */
    addToCart: function () {
        this.productListView.$('.add-to-cart').trigger('saveProduct');
    }
});