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
        this.$('img').one('load', this.resizeAnchor).one('error', this.useDefaultImage);
        return this;
    },

    remove: function (e) {
        e.stopPropagation();
        Backbone.View.prototype.remove.call(this);
    },

    useDefaultImage: function (e) {
        $(e.currentTarget).attr('src', '//placehold.it/356x390');
    },

    resizeAnchor: function (e) {
        $(e.currentTarget).parent().height($(e.currentTarget).parent().width() * 390 / 356);
        $(e.currentTarget).css('max-height', '100%');
    }
});