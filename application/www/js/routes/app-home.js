App.Routes.App = Backbone.Router.extend({

    // Initialize the app
    initialize: function (options) {
        // Initialize collections/models
        this.contact = new App.Models.Contact();
        this.products = new App.Collections.Products();
        this.categories = new App.Collections.Categories();

        // Initialize views (widgets)
        new App.Views.SearchBarView({collection: this.products});
        new App.Views.CartBarView({model: this.contact, collection: this.products});
        new App.Views.Nav({collection: this.categories});
        this.content = new App.Views.ContentView();
        this.body = new App.Views.BodyView();

        // Fetch initial load of data and save references to the XHR requests in case we need to know when they are done
        this.contactXHR = this.contact.fetch();
        this.productsXHR = this.products.fetch({reset: true});
        this.categoriesXHR = this.categories.fetch({reset: true});
    },

    routes: {
        '': 'homePage',
        'product/:id': 'productPage',
        'category(/:id)': 'categoryPage',
        'cart': 'cartPage',
        'search': 'searchPage'
    },

    /**
     * Display the shopping cart home page
     */
    homePage: function () {
        //this.content.switchView(new App.Views.BasicView({template: App.Templates['home']}).render());
        this.categoryPage();
    },

    /**
     * Display the product page
     *
     * @param {String} itemCode The product item code
     */
    productPage: function (itemCode) {
        $.when(this.productsXHR).then(function () {
            console.log('Navigated to product page');
            // TODO: Make this work
            //this.content.switchView(new App.Views.ProductPage({model: this.products.get(itemCode)}).render());
        }.bind(this));
    },

    /**
     * Display the products for the given category
     *
     * @param {String} categoryCode - The category to display
     */
    categoryPage: function (categoryCode) {
        console.log('navigated to category page');
        $.when(this.productsXHR).then(function () {
            var view = new App.Views.ProductListPage({collection: this.products, categories: this.categories}).renderByCategory(categoryCode, $.getParam('offset'), $.getParam('limit'));
            this.content.switchView(view);
        }.bind(this));
    },

    /**
     * Display the shopping cart
     */
    cartPage: function () {
        $.when(this.productsXHR).then(function () {
            var view = new App.Views.CartPage({collection: this.products, model: this.contact}).render();
            this.content.switchView(view);
        }.bind(this));
    },

    /**
     * Display the products based on the "q" GET param.
     */
    searchPage: function () {
        $.when(this.productsXHR).then(function () {
            if (_.isEmpty($.getParam('q'))) {
                var view = new App.Views.ProductListPage({collection: this.products, categories: this.categories}).renderByCategory('', $.getParam('offset'), $.getParam('limit'));
            } else {
                var view = new App.Views.ProductListPage({collection: this.products}).renderSearchResults($.getParam('q'), $.getParam('offset'), $.getParam('limit'));
            }
            this.content.switchView(view);
        }.bind(this));
    }
});


app = new App.Routes.App();
Backbone.history.start({pushState: true});
