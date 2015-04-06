/**
 * Created by James on 11/4/13.
 */


App.Views.ProductView = Backbone.View.extend({
    tagName: "li",
    template: Handlebars.compile($("#productView").html()),
    render: function () {
        this.$el.html(this.template(this.model.toJSON())); // Render the model based on the specified template.
        return this;
    },
    events: {
        "click .add-to-cart": "clickAddButton",
        "click .details": "clickProduct"
    },
    clickAddButton: function () {
        this.model.set('_quantity', $('[name="quantity"]', this.$el).val());
    },
    clickProduct: function (e) {
        $('#product-list-description').html(this.model.get('ItemCodeDesc'));
        $('#product-list').html(this.$el.html());
    }
});


// Header of the web page.  Needs product collection to listen to cart changes.
App.Views.HeaderView = Backbone.View.extend({
    initialize: function() {
        this.collection.on('change:cart', this.renderCart)
    },
    template: Handlebars.compile($("#cart-body-info").html()),
    render: function() {

    },
    renderCart: function() {

    }
});


// The navigation view.
App.Views.NavView = Backbone.View.extend({
    events: {
        "click a": "clickNavItem"
    },
    clickNavItem: function (e) {
        var categoryCode = $(e.target).attr('href').substring(1);
        var category = this.collection.findCategory(categoryCode);
        $('#product-list-description').html(category.get('<h1>CategoryCodeDesc</h1>'));
        $('#product-list').html("products");

        e.preventDefault();
    }
});
