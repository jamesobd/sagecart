App.Collections.Products = Backbone.Collection.extend({
    url: '/api/products',

    model: App.Models.Product,

    checkout: function (options) {
        this.id = 'checkout';
        $.postJSON('/api/products/checkout', this.toJSON(), {
            success: function (data) {
                this.masCartResults = data;

                // Validate and compare SAGE cart with local cart, looking for errors
                var errors = [];

                // Make sure the quantity and price in the SAGE cart match the local cart
                data.Detail.forEach(function (product) {
                    if (product.Quantity != this.get(product.ItemCode).get('_Quantity')) {
                        errors.push('The server claims ' + product.Quantity + ' of product ' + product.ItemCode + ' were added to the cart instead of ' + this.get(product.ItemCode).get('_Quantity') + '.');
                    }
                    if (product.UnitPrice != this.get(product.ItemCode).get('CustomerPrice')) {
                        errors.push('The price of product ' + product.ItemCode + ' has changed to $' + product.UnitPrice + '.');
                    }
                }, this);

                // Make sure the total amount matches the SAGE cart
                if (data.NonTaxableAmt != this.getSubtotal().toFixed(2)) {
                    errors.push('The server claims the subtotal has changed to $' + data.NonTaxableAmt + '.');
                }

                if (_.isEmpty(errors)) {
                    options.success && options.success(data);
                } else {
                    options.error && options.error(errors);
                }
            }.bind(this)
        });
    },

    /**
     * Get all products that belong to a given category
     *
     * @param category
     * @param offset
     * @param limit
     * @returns {Array.<T>|*}
     */
    getByCategory: function (category, offset, limit) {
        return _.paginate(this.filter(function (product) {
            return _.isEmpty(category) || product.get('Categories').indexOf(category) > -1;
        }), offset, limit);
    },

    /**
     * Get all products that have a quantity > 0
     * aka Cart
     *
     * @returns {Array.<T>|*}
     */
    getByQuantity: function (offset, limit) {
        return _.paginate(this.filter(function (product) {
            return product.get('_Quantity') > 0;
        }), offset, limit);
    },

    /**
     * Search for products whose properties have str in it (space delimited)
     */
    search: function (str, offset, limit) {
        var searchRegex = new RegExp(str.replace(/ /g, "|"), "i"); // Define the search regex string.
        var searchFields = ['ItemCode', 'ItemName', 'ExtendedDescriptionText', 'ItemCodeDesc', 'ItemLongDesc'];

        return _.paginate(this.filter(function (product) {
            // Search in each searchField
            for (var j = 0; j < searchFields.length; j++) {
                if (product.get(searchFields[j]).search(searchRegex) > -1) {
                    return true;
                }
            }
        }), offset, limit);
    },

    getPalletsInCart: function () {
        return Number(this.reduce(function (sum, product) {
            return sum + product.getPalletTotal();
        }, 0));
    },

    getSubtotal: function () {
        return Number(this.reduce(function (sum, product) {
            return sum + product.getTotal();
        }, 0));
    },

    getFreightAmt: function () {
        return Number(this.masCartResults && this.masCartResults['FreightAmt'] ? this.masCartResults['FreightAmt'] : 0);
    },

    getSalesTaxAmt: function () {
        return Number(this.masCartResults && this.masCartResults['SalesTaxAmt'] ? this.masCartResults['SalesTaxAmt'] : 0);
    },

    /**
     * Get the cart total
     */
    getTotal: function () {
        return Number(this.getSubtotal() + this.getFreightAmt() + this.getSalesTaxAmt());
    }
});