App.Views.CartPage = Backbone.View.extend({
    initialize: function () {
        this.commentsMaxQuantity = 2048;
    },
    events: {
        'click #cart-checkout': 'checkout',
        'click #cart-cancel-submit': 'cancelSubmit',
        'click #cart-submit': 'submit',
        "keydown #shipping-comments": "limitComments",
        "keyup #shipping-comments": "updateCommentsChars"
    },

    /**
     * Render the view
     *
     * @param offset {Number} The offset where results begin
     * @param limit {Number} The number of results after offset to return
     */
    render: function (offset, limit) {
        this.$el.empty();

        var products = this.collection.getByQuantity(offset, limit);

        // Display cart header
        this.$el.append(App.Templates['content-header']({header: 'Shopping Cart'}));

        // Show product list
        this.$el.append(new App.Views.ProductListView().renderCart(products).el);

        // Show product list header
        var viewData = {
            'totalPallets': this.collection.getPalletsInCart(),
            'subtotal': this.collection.getSubtotal(),
            'ShipToAddress': this.model.get('ShipToAddress'),
            'FreightAmt': this.collection.getFreightAmt(),
            'SalesTaxAmt': this.collection.getSalesTaxAmt(),
            'total': this.collection.getTotal(),
            'UDF_FREIGHT_INFO': this.model.get('UDF_FREIGHT_INFO')
        };
        this.$el.append(App.Templates['cart-footer'](viewData));

        return this;
    },

    /**
     * Triggers all items to save their product model
     */
    addToCart: function () {
        this.$('.item').trigger('saveProduct');
    },

    /**
     * Check out the cart with SAGE
     */
    checkout: function (e) {
        $(e.target).button('loading').spin();
        this.collection.checkout({
            success: function (data) {
                $(e.target).button('reset');
                this.$('#cart-footer-checkout').slideUp();
                this.$('#cart-footer-submit').slideDown();
            }.bind(this),
            error: function (errors) {
                alert(errors);
            }
        });
    },

    cancelSubmit: function () {
        this.$('#cart-footer-submit').slideUp();
        this.$('#cart-footer-checkout').slideDown();
    },

    submit: function () {
        // TODO: submit the order
    },

    /**
     * Remove the sub-views and then this page itself
     */
    remove: function () {
        this.$('> *').trigger('remove');
        Backbone.View.prototype.remove.call(this);
    },

    limitComments: function (e) {
        var key = e.keyCode;

        if (e.target.value.length < (this.commentsMaxQuantity)
            || key === 8 || key === 46 || key === 9 || key === 37 || key === 39  // Backspace, Delete, Tab, Left, and Right
            || (e.ctrlKey && key === 90) || key === 27) // Undo, Escape
        {
            return true;
        }
        return false;
    },

    updateCommentsChars: function(e) {
        if(e.target.value.length > this.commentsMaxQuantity) {
            $('#shipping-comments').html($(e.target).val().substr(0,this.commentsMaxQuantity));
        }
        $('#comments-chars').html(e.target.value.length + ' of ' + this.commentsMaxQuantity);
    }
});