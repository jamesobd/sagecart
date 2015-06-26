App.Views['category-grid-item'] = Backbone.View.extend({
    initialize: function (params) {
        this.$el.addClass(params.gridSize);
    },

    attributes: {
        class: 'category col-lg-2 col-md-2 col-sm-4 col-xs-6 item'
    },

    events: {
        'remove': 'remove'
    },

    template: App.Templates['items/category-grid-item'],

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
        $(e.currentTarget).attr('src', '//placehold.it/280x326');
    },

    resizeAnchor: function (e) {
        $(e.currentTarget).parent().height($(e.currentTarget).parent().width() * 280 / 326);
        $(e.currentTarget).css('max-height', '100%');
    }
});