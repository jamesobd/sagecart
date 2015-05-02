App.Collections.Categories = Backbone.Collection.extend({
    initialize: function (categories, options) {
        this.XHR = $.Deferred().reject();
        this.listenTo(options.user, 'login', function () {this.XHR = this.fetch({reset: true})}.bind(this));
    },

    url: '/api/categories',

    model: App.Models.Category
});