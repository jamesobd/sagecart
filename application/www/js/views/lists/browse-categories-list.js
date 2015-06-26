App.Views['browse-categories-list'] = Backbone.View.extend({
    initialize: function () {
        this.categories = app.categories;
    },

    events: {
        'remove': 'remove'
    },

    render: function () {
        this.categories.getMainNavigation().forEach(function (category, i) {
            // Add the Bootstrap Responsive column resets (Bootstrap Responsive utilities)
            if (i % 6 == 0 && i > 0) this.$el.append('<div class="clearfix visible-lg-block visible-md-block"></div>');
            if (i % 3 == 0 && i > 0) this.$el.append('<div class="clearfix visible-sm-block"></div>');
            if (i % 2 == 0 && i > 0) this.$el.append('<div class="clearfix visible-xs-block"></div>');

            this.$el.append(new App.Views['category-grid-item']({
                model: category,
                gridSize: this.$el.data('grid-size')
            }).render().el);

        }.bind(this));
        return this;
    },

    remove: function (e) {
        e.stopPropagation();
        this.$('> .item').trigger('remove');
        Backbone.View.prototype.remove.call(this);
    }
});