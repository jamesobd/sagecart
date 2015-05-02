App.Routes.MainRoute = Backbone.Router.extend({

    // Initialize the app
    initialize: function (options) {
        // Initialize collections/models
        this.user = new App.Models.User();
        this.products = new App.Collections.Products([], {user: this.user});
        // TODO: Re-enable this
        //this.categories = new App.Collections.Categories([], {user: this.user});


        // Initialize views (widgets)
        //new App.Views.SearchBarView({collection: this.products});
        //new App.Views.CartBarView({model: this.contact, collection: this.products});
        //new App.Views.Nav({collection: this.categories});
        //this.content = new App.Views.ContentView();
        this.layout = new App.Views.MainLayout({model: this.user});

        // When the user signs in or out we redirect to the home page.
        this.listenTo(this.user, 'login logout', function () {
                Backbone.history.loadUrl(Backbone.history.getFragment());
            }.bind(this)
        );
    },

    routes: {
        'products/:id': 'productPage',
        'categories(/:id)': 'categoryPage',
        'cart': 'cartPage',
        'search': 'searchPage',
        '*path': 'autoRoutePage' // Catch all other pages and auto route
    },

    /**
     * Default page route
     * @param page
     */
    autoRoutePage: function (page) {
        if (this.user.XHR.state() == 'resolved') {
            $.when(this.products.XHR).always(function () {
                this.layout.switchPage(new App.Views.AutoRoutePage({page: page ? page : 'home-slideshow'}).render());
            }.bind(this));
        } else if (this.user.XHR.state() == 'rejected') {
            this.layout.switchPage(new App.Views.AutoRoutePage({page: 'login'}).render());
        }
    },

    /**
     * Display the product page
     *
     * @param {String} itemCode The product item code
     */
    productPage: function (itemCode) {
        if (this.user.XHR.state() == 'resolved') {
            $.when(this.products.XHR).always(function () {
                this.layout.switchPage(new App.Views.ProductPage({model: this.products.get(itemCode)}).render($.getParam('ver')));
            }.bind(this));
        } else if (this.user.XHR.state() == 'rejected') {
            this.layout.switchPage(new App.Views.AutoRoutePage({page: 'login'}).render());
        }
    },

    /**
     * Display the products for the given category
     *
     * @param {String} categoryCode - The category to display
     */
    categoryPage: function (categoryCode) {
        console.log('navigated to category page');
        $.when(this.XHR.products).always(function () {
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
        $.when(this.XHR.products).always(function () {
            var view = new App.Views.CartPage({collection: this.products, model: this.user}).render();
            this.content.switchPage(view);
        }.bind(this));
    },

    /**
     * Display the products based on the "q" GET param.
     */
    searchPage: function () {
        $.when(this.XHR.products).always(function () {
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
