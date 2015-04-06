/**
 * Created by James on 11/4/13.
 */


Categories = Backbone.Collection.extend({
    model: function (attrs, options) {
        return new App.Models.Category(attrs, options)
    },
    // Recursively find the category we're looking for
    findCategory: function (categoryCode, categories) {
        categories = (typeof categories == "undefined") ? this : categories;

        for (var i = 0; i < categories.length; i++) {
            // Is this the category we are looking for?
            if (categories.at(i).get('CategoryCode') == categoryCode) {
                return categories.at(i);
            }
            // Are we at the end of a branch?
            if (categories.at(i).get('Children').length == 0) {
                continue;
            }
            // Search the children
            var result = this.findCategory(categoryCode, categories.at(i).get('Children'));
            if (result) {
                return result;
            }
        }
    }
});


App.Collections.Products = Backbone.Collection.extend({
    model: function (attrs, options) {
        return new App.Models.Product(attrs, options)
    },
    sync: function (method, model, options) {
        // If the cart is being updated, use the correct url
        if (method === "create" || method === "update")
            options.url = "/ajax/updatecart";
        return Backbone.sync(method, model, options);
    },
    search: function (searchString, searchFields) {
        var searchRegex = new RegExp(searchString.replace(/ /g, "|"), "i");
        return this.filter(function (product) {
            for (var i = 0; x < searchFields.length; i++) {
                if (product.get(searchFields[i]).search(searchRegex) > -1) {
                    return true;
                }
            }
            return false;
        });
    },
    getCart: function () {
        return this.filter(function (product) {
            return product.get('_quantity') > 0;
        });
    }
});