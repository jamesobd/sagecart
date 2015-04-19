App.Views.MainLayout = Backbone.View.extend({
    initialize: function (options) {
        // When the user signs in or out we redirect to the home page.
        this.listenTo(this.model, 'login', this.renderLogin);
        this.listenTo(this.model, 'logout', this.renderLogout);
    },
    el: 'body',

    events: {
        'submit form[action="#login"]': 'submitLogin',
        'click a[href^="#logout"]': 'submitLogout',
        'click a[href^="/"]': 'navigateAnchor',
        'submit form[action^="/"]': 'navigateForm'
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
        app.navigate(this.$(e.currentTarget).attr('action') + '?' + this.$(e.currentTarget).serialize(), {trigger: true});
        this.$(e.currentTarget)[0].reset();
    },

    /**
     * Render adjustments to this layout when the user logs-in
     */
    renderLogin: function () {
        this.$('.logout-btn').show();
        this.$('.login-btn').hide();
        this.$('#loginModal').modal('hide');
    },

    /**
     * Render adjustments to this layout when the user logs-out
     */
    renderLogout: function () {
        this.$('.logout-btn').hide();
        this.$('.login-btn').show();
    }
});