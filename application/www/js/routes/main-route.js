App.Routes.MainRoute = Backbone.Router.extend({

    // Initialize the app
    initialize: function (options) {
        // Initialize collections/models
        this.user = new App.Models.User();
        //this.products = new App.Collections.Products();
        //this.categories = new App.Collections.Categories();

        // Initialize views (widgets)
        //new App.Views.SearchBarView({collection: this.products});
        //new App.Views.CartBarView({model: this.contact, collection: this.products});
        //new App.Views.Nav({collection: this.categories});
        //this.content = new App.Views.ContentView();
        this.layout = new App.Views.MainLayout({model: this.user});

        // Fetch initial load of data and save references to the XHR requests in case we need to know when they are done
        this.userXHR = this.user.fetch();
        //this.productsXHR = this.products.fetch({reset: true});
        //this.categoriesXHR = this.categories.fetch({reset: true});

        $.when(this.userXHR).then(function () {
            this.layout.$el.trigger('user:login');
        }.bind(this));
    },

    routes: {
        '': 'homePage',
        'logout': 'logoutPage',
        'product/:id': 'productPage',
        'category(/:id)': 'categoryPage',
        'cart': 'cartPage',
        'search': 'searchPage',
        '*page': 'defaultPage' // Catch-all default page
    },

    /**
     * Home page
     */
    homePage: function () {
        $.when(this.userXHR).always(function () {
            this.layout.switchPage(new App.Views.HomePage({model: this.user}).render());
        }.bind(this));
    },

    logoutPage: function () {
        $.when(this.userXHR).always(function () {
            this.user.logout();
            this.layout.switchPage(new App.Views.HomePage({model: this.user}).render());
        }.bind(this));
    },

    /**
     * Default page route
     * @param page
     */
    defaultPage: function (page) {
        this.layout.switchPage(new App.Views.DefaultPage({page: page, className: page + '-page'}).render());
    },

    /**
     * Display the product page
     *
     * @param {String} itemCode The product item code
     */
    productPage: function (itemCode) {
        $.when(this.productsXHR).always(function () {
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
        $.when(this.productsXHR).always(function () {
            var view = new App.Views.ProductListPage({
                collection: this.products,
                categories: this.categories
            }).renderByCategory(categoryCode, $.getParam('offset'), $.getParam('limit'));
            this.content.switchPage(view);
        }.bind(this));
    },

    /**
     * Display the shopping cart
     */
    cartPage: function () {
        $.when(this.productsXHR).always(function () {
            var view = new App.Views.CartPage({collection: this.products, model: this.user}).render();
            this.content.switchPage(view);
        }.bind(this));
    },

    /**
     * Display the products based on the "q" GET param.
     */
    searchPage: function () {
        $.when(this.productsXHR).always(function () {
            if (_.isEmpty($.getParam('q'))) {
                var view = new App.Views.ProductListPage({
                    collection: this.products,
                    categories: this.categories
                }).renderByCategory('', $.getParam('offset'), $.getParam('limit'));
            } else {
                var view = new App.Views.ProductListPage({collection: this.products}).renderSearchResults($.getParam('q'), $.getParam('offset'), $.getParam('limit'));
            }
            this.content.switchPage(view);
        }.bind(this));
    }
});


app = new App.Routes.MainRoute();
Backbone.history.start({pushState: true});
