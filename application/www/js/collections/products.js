App.Collections.Products = Backbone.Collection.extend({
    initialize: function (products, options) {
        this.XHR = $.Deferred();
        this.listenTo(options.user, 'login', function () {
            this.fetch({
                success: function () {
                    this.XHR.resolve();
                }.bind(this),
                error: function () {
                    this.XHR.reject();
                }.bind(this), reset: true
            })
        }.bind(this));
    },

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
     * @param [offset] Number
     * @param [limit] Number
     * @returns {Array.<T>|*}
     */
    getByCategory: function (category, offset, limit) {
        return _.paginate(this.filter(function (product) {
            return _.isEmpty(category) || product.get('categories').indexOf(category) > -1;
        }), offset, limit);
    },

    /**
     * Returns all products based of GET param filters
     */
    getByURL: function() {
        var minPrice = $.getParam('minPrice') ? Number($.getParam('minPrice')) : 0;
        var maxPrice = $.getParam('maxPrice') ? Number($.getParam('maxPrice')) : Number.MAX_VALUE;
        var category = $.getSegment(1) == 'categories' ? $.getSegment(2) : '';

        return this.filter(function (product) {
            var isWithinPriceRange = minPrice <= product.get('standardunitprice') && product.get('standardunitprice') <= maxPrice;
            var isCorrectCategory = category ? product.get('categories').indexOf(category) > -1 : true;
            return isWithinPriceRange && isCorrectCategory;
        });
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

    getSubtotal: function () {
        return Number(this.reduce(function (sum, product) {
            return sum + product.getTotal();
        }, 0));
    },

    /**
     * Get the cart total
     */
    getTotal: function () {
        return Number(this.getSubtotal() + this.getFreightAmt() + this.getSalesTaxAmt());
    }
});