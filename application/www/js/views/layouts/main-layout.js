App.Views.MainLayout = Backbone.View.extend({
    initialize: function (options) {
        //this.toolbar = new App.Views.ToolbarView({collection: this.collection});
        //this.footer = new App.Views.FooterView({collection: this.news});
    },
    el: 'body',

    events: {
        'click a[href^="/"]': 'navigateAnchor',
        'submit form[action^="/"]': 'navigateForm'
    },


    /**
     * Switches the #content view
     * @param name
     * @param view
     */
    switchPage: function (view) {
        this.$('#content > *').trigger('remove');
        this.$('#content').html(view.el);
    },

    /**
     * Use History API on anchors by default since we are doing single page navigation
     */
    navigateAnchor: function (e) {
        e.preventDefault();
        app.navigate($(e.target).attr('href'), {trigger: true});
    },

    /**
     * Use History API on forms by default since we are doing single page navigation
     */
    navigateForm: function (e) {
        e.preventDefault();
        app.navigate($(e.target).attr('action') + '?' + $(e.target).serialize(), {trigger: true});
        this.$('form')[0].reset();
    }
});