/**
 * Created by James on 11/4/13.
 */

/**
 * Product category model
 */
App.Models.Category = Backbone.Model.extend({
    idAttribute: "CategoryCode",
    initialize: function () {
        this.set('Products', new App.Collections.Products(this.get('Products')));
        App.products.add(this.get('Products'));
        this.set('Children', new App.Collections.Categories(this.get('Children')));
    }
});


/**
 * Product model
 */
App.Models.Product = Backbone.Model.extend({
    idAttribute: "ItemCode",
    initialize: function () {
        this.on('change:_Quantity', this.updateTotal);
    },
    updateTotal: function () {
        this.set("ItemTotalPrice", (this.get("_Quantity") * this.get("CustomerPrice")));
    }
});