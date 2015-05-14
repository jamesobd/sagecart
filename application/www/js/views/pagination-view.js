App.Views['pagination-view'] = Backbone.View.extend({
    initialize: function (params) {
        this.products = app.products;
    },

    events: {
        'remove': 'remove',
        'click a': 'navigate'
    },

    render: function () {
        // Get the limit and offset
        var limit = $.getParam('limit') ? Number($.getParam('limit')) : app.defaults.limit; // If the limit is not set use defaults.limit
        limit = limit < 1 ? app.defaults.limit : limit; // If the limit is below 1 set to defaults.limit
        limit = limit > this.products.length ? this.products.length : limit; // If the limit is greater than products.length set to products.length

        var offset = $.getParam('offset') ? Math.floor(Number($.getParam('offset')) / limit) * limit : app.defaults.offset; // If the offset is not set use the default offset
        offset = offset < 0 ? app.defaults.offset : offset; // If the offset is less than 0 then set to defaults.offset
        offset = offset > this.products.length ? app.defaults.offset : offset; // If the offset is greater than products.length set to defaults.offset

        // Calculate a few things like total page range, location, and visible high/low range.
        var totalPages = Math.floor(this.products.length / limit);
        var currentPage = Math.floor(offset / limit) >= 0 ? Math.ceil(offset / limit) : 0;
        currentPage = currentPage > totalPages ? totalPages : currentPage; // If the currentPage is greater than the totalPages set to totalPages
        var paginationSize = Math.min(app.defaults.paginationSize, totalPages + 1);
        var lowPage = currentPage - Math.floor(paginationSize / 2);
        lowPage = lowPage < 0 ? 0 : lowPage; // If the lowPage is less than 1 then set to 1
        lowPage = lowPage > totalPages - paginationSize + 1 ? totalPages - paginationSize + 1 : lowPage;
        var highPage = lowPage + paginationSize - 1 > totalPages ? totalPages : lowPage + paginationSize - 1; // If the highPage is greater than totalPages set to totalPages

        // Is there only one page?
        if (this.products.length <= limit) {
            return;
        }

        if (currentPage > 0) {
            this.$el.append('<li class="prev-page"><a class="icon-arrow-left" href="#" data-offset="' + (currentPage - 1) * limit + '"></a></li>');
        } else {
            this.$el.append('<li class="prev-page invisible"><a class="icon-arrow-left" href="#"></a></li>');
        }
        for (var i = lowPage; i <= highPage; i++) {
            if (i == currentPage) {
                this.$el.append('<li class="active"><a href="#" data-offset="' + i * limit + '">' + (i + 1) + '</a></li>');
            } else {
                this.$el.append('<li><a href="#" data-offset="' + i * limit + '">' + (i + 1) + '</a></li>');
            }
        }
        if (currentPage < totalPages) {
            this.$el.append('<li class="next-page"><a class="icon-arrow-right" href="#" data-offset="' + (currentPage + 1) * limit + '"></a></li>');
        } else {
            this.$el.append('<li class="next-page invisible"><a class="icon-arrow-right" href="#"></a></li>');
        }
        return this;
    },

    /**
     * Change pagination page
     */
    navigate: function (e) {
        e.preventDefault();
        $.setParam('offset', $(e.currentTarget).data('offset'));
        Backbone.history.loadUrl(Backbone.history.getFragment());
    }
});