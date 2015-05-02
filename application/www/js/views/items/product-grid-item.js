App.Views['product-grid-item'] = Backbone.View.extend({
    initialize: function(params) {
        this.$el.addClass(params.gridSize);
    },

    events: {
        'remove': 'remove'
    },

    template: App.Templates['items/product-grid-item'],

    render: function () {
        this.$el.html(this.template(this.model.toJSON()));
        return this;
    },

    remove: function(e) {
        e.stopPropagation();
        Backbone.View.prototype.remove.call(this);
    }
});