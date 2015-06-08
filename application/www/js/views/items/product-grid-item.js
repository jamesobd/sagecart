App.Views['product-grid-item'] = Backbone.View.extend({
    initialize: function (params) {
        this.$el.addClass(params.gridSize);
    },

    events: {
        'remove': 'remove'
    },

    template: App.Templates['items/product-grid-item'],

    render: function () {
        this.$el.html(this.template(this.model.toJSON()));
        console.log(this.$('a').width());
        this.$('img').one('load', this.resizeImage).one('error', this.useDefaultImage).each(function (i, e) {
            $el = $(e);
            if ($el.data('src')) {
                $el.attr('src', $el.data('src'));
            }
        });
        return this;
    },

    remove: function (e) {
        e.stopPropagation();
        Backbone.View.prototype.remove.call(this);
    },

    useDefaultImage: function (e) {
        $(e.currentTarget).attr('src', '//placehold.it/356x390');
    },

    resizeImage: function (e) {
        $(e.currentTarget).parent().height($(e.currentTarget).parent().width() * 390 / 356);
    }
});