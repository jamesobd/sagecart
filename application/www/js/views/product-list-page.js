App.Views.ProductListPage = Backbone.View.extend({
    initialize: function (options) {
        this.categories = options.categories;
    },

    events: {},

    /**
     * Display the searched for products
     *
     * @param str {String} The search string
     * @param offset {Number} The offset where results begin
     * @param limit {Number} The number of results after offset to return
     */
    renderSearchResults: function (str, offset, limit) {
        this.$el.empty();

        var products = this.collection.search(str, offset, limit);

        // Display Category Heading
        this.$el.append(App.Templates['content-header']({header: 'Search Results for: ' + str}));

        //  Show items per page drop-down if needed
        if (products.length > 10) {
            this.$el.append(new App.Views.ProductLimitView().render(limit).el);
        }

        var productListView = new App.Views.ProductListView();
        var palletInfoView1 = new App.Views.PalletInfoView({
            collection: this.collection,
            productListView: productListView
        });
        var palletInfoView2 = new App.Views.PalletInfoView({
            collection: this.collection,
            productListView: productListView
        });

        // Show product list header
        this.$el.append(palletInfoView1.render().el);

        // Show product list
        this.$el.append(productListView.render(products).el);

        // Show product list header
        this.$el.append(palletInfoView2.render().el);

        return this;
    },

    renderByCategory: function (categoryCode, offset, limit) {
        this.$el.empty();

        var categoryCodeDesc = categoryCode ? this.categories.get(categoryCode).get('CategoryCodeDesc') : 'All Items';
        var products = this.collection.getByCategory(categoryCode, offset, limit);

        // Display Category Heading
        this.$el.append(App.Templates['content-header']({header: categoryCodeDesc}));

        //  Show items per page drop-down if needed
        if (products.length > 10) {
            this.$el.append(new App.Views.ProductLimitView().render(limit).el);
        }

        var productListView = new App.Views.ProductListView();
        var palletInfoView1 = new App.Views.PalletInfoView({
            collection: this.collection,
            productListView: productListView
        });
        var palletInfoView2 = new App.Views.PalletInfoView({
            collection: this.collection,
            productListView: productListView
        });

        // Show product list header
        this.$el.append(palletInfoView1.render().el);

        // Show product list
        this.$el.append(productListView.render(products).el);

        // Show product list header
        this.$el.append(palletInfoView2.render().el);

        return this;
    },

    /**
     * Triggers all items to save their product model
     */
    addToCart: function () {
        this.$('.item').trigger('saveProduct');
    },

    /**
     * Remove the sub-views and then this page itself
     */
    remove: function () {
        this.$('> *').trigger('remove');
        Backbone.View.prototype.remove.call(this);
    }
});