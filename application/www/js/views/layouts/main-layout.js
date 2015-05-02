App.Views.MainLayout = Backbone.View.extend({
    initialize: function (options) {
        // When the user signs in or out we redirect to the home page.
        this.listenTo(this.model, 'login', this.renderLogin);
        this.listenTo(this.model, 'logout', this.renderLogout);
    },
    el: 'body',

    events: {
        'click a[href^="/"]': 'navigateAnchor',
        'submit form[action^="/"]': 'navigateForm',
        'submit form[action="#login"]': 'submitLogin',
        'click a[href^="#logout"]': 'submitLogout'
    },


    /**
     * Switches the #content view
     * @param view
     */
    switchPage: function (view) {
        // Remove any sub-views in the content area
        this.$('#content [data-view]').trigger('remove');

        this.$('#content > *').trigger('remove');
        this.$('#content').html(view.el);

        // Load sub-views in the content area
        this.$('#content [data-view]').each(function (i, subView) {
            if (App.Views[$(subView).attr('data-view')]) {
                new App.Views[$(subView).attr('data-view')]({
                    el: subView
                }).render();
            }
        });
    },

    /**
     * Use History API on anchors by default since we are doing single page navigation
     */
    navigateAnchor: function (e) {
        e.preventDefault();
        app.navigate(this.$(e.currentTarget).attr('href'), {trigger: true});
    },

    /**
     * Use History API on forms by default since we are doing single page navigation
     */
    navigateForm: function (e) {
        e.preventDefault();
        // TODO: Look at posting the form data as POST instead of GET
        app.navigate(this.$(e.currentTarget).attr('action') + '?' + this.$(e.currentTarget).serialize(), {trigger: true});
        this.$(e.currentTarget)[0].reset();
    },

    /**
     * Submit the login form and make adjustments to the login form
     */
    submitLogin: function (e) {
        e.preventDefault();
        this.model.login($(e.currentTarget).serializeObject(), {
            success: function () {
                this.$(':input', e.currentTarget).prop("disabled", false);
                this.$('button[type="submit"]', e.currentTarget).spin(false);
                this.renderLogin();
            }.bind(this),
            error: function (e) {
                var message = _.isObject(e.responseJSON.message) ? _.values(e.responseJSON.message).join('<br>') : e.responseJSON.message;
                alert(message);
            }
        });
        this.$(':input', e.currentTarget).prop("disabled", true);
        this.$('button[type="submit"]', e.currentTarget).spin({color: '#000'});
    },

    /**
     * Submit the logout anchor
     */
    submitLogout: function (e) {
        e.preventDefault();
        this.model.logout();
    },

    /**
     * Render adjustments to this layout when the user logs-in
     */
    renderLogin: function () {
        this.$('.logout-btn').show();
        this.$('.login-btn').hide();
        this.$('#loginModal').modal('hide');
        this.$('.catalog-block .catalog').css('visibility', 'visible');
    },

    /**
     * Render adjustments to this layout when the user logs-out
     */
    renderLogout: function () {
        this.$('.logout-btn').hide();
        this.$('.login-btn').show();
        this.$('.catalog-block .catalog').css('visibility', 'hidden');
    }
});