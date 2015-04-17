App.Views.MainLayout = Backbone.View.extend({
    initialize: function (options) {
        //this.listenTo(this.model, 'login', )
    },
    el: 'body',

    events: {
        'click a[href^="/"]': 'navigateAnchor',
        'submit form[action^="/"]': 'navigateForm',
        'submit form.login-form': 'login'
    },


    /**
     * Switches the #content view
     * @param view
     */
    switchPage: function (view) {
        this.$('#content > *').trigger('remove');
        this.$('#content').html(view.el);
    },


    /**
     * Adjust this layout when a user logs-in
     */
    login: function (e) {
        e.preventDefault();
        this.model.login($(e.currentTarget).serializeObject());
    },

    /**
     * Use History API on anchors by default since we are doing single page navigation
     */
    navigateAnchor: function (e) {
        e.preventDefault();
        app.navigate($(e.currentTarget).attr('href'), {trigger: true});
    },

    /**
     * Use History API on forms by default since we are doing single page navigation
     */
    navigateForm: function (e) {
        e.preventDefault();
        app.navigate($(e.currentTarget).attr('action') + '?' + $(e.currentTarget).serialize(), {trigger: true});
        this.$('form')[0].reset();
    }
});