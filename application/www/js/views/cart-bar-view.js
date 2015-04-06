App.Views.CartBarView = Backbone.View.extend({
    el: '#cart-bar',

    initialize: function () {
        this.listenTo(this.model, 'change', this.updateName);
        this.listenTo(this.collection, 'sync', this.updateCart);
    },

    events: {
        'click #cart': 'navigateToCartPage',
        'click #logout a': 'logout'
    },
    logout: function (e) {
        e.preventDefault();
        $.get('/api/contacts/logout', function () {
            window.location.href = '';
        });
    },
    updateName: function () {
        this.$('#name').html(this.model.get('ContactName'));
    },
    updateCart: function () {
        var cartProducts = this.collection.filter(function (product) {
            return product.get('_Quantity') > 0;
        });

        var productsTotal = cartProducts.reduce(function (value, product) {
            return value + product.get('CustomerPrice') * product.get('_Quantity');
        }, 0);

        this.$('#cart-amount').html('$' + productsTotal.toFixed(2));
        this.$('#cart-items').html('(' + cartProducts.length + ' items)');
    },
    navigateToCartPage: function() {
        app.navigate('cart', {trigger: true});
    }
});