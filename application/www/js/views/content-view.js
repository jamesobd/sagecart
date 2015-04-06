App.Views.ContentView = Backbone.View.extend({
    el: '#content',

    switchView: function(view) {
        this.view && this.view.remove();
        this.view = view;
        this.$el.html(this.view.el);
    }
});