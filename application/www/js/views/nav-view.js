App.Views.Nav = Backbone.View.extend({
    el: '#main-nav',

    collection: new App.Collections.Categories(),

    template: App.Templates['nav'],

    initialize: function () {
        this.collection.fetch({
            success: function () {
                this.render();
            }.bind(this),
            error: function() {
                alert('Unable to get a list of product categories.');
            }.bind(this)
        });
    },

    events: {
        //'submit': 'validateSubmit'
    },

    render: function () {
        this.$el.html(this.template({categories: this.collection.toJSON()}));
    }

});