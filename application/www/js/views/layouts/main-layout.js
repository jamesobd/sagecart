App.Views.MainLayout = Backbone.View.extend({
    initialize: function (params) {
        this.categories = params.categories;

        // When the user signs in or out we redirect to the home page.
        this.listenTo(this.model, 'login', this.renderLogin);
        this.listenTo(this.model, 'logout', this.renderLogout);
        this.listenTo(this.categories, 'update sync', this.renderCategoriesNav);
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
        $('body').scrollTop(0);

        // Load sub-views in the content area
        this.$('#content [data-view]').each(function (i, subView) {
            if (App.Views[$(subView).data('view')]) {
                new App.Views[$(subView).data('view')]({
                    el: subView
                }).render();
            } else {
                console.error('The sub-view does not exist', $(subView).data('view'));
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
                $(':input', e.currentTarget).prop("disabled", false);
                $('button[type="submit"]', e.currentTarget).spin(false);
                this.renderLogin();
            }.bind(this),
            error: function (e) {
                var message = _.isObject(e.responseJSON.message) ? _.values(e.responseJSON.message).join('<br>') : e.responseJSON.message;
                alert(message);
            }
        });
        $(':input', e.currentTarget).prop("disabled", true);
        $('button[type="submit"]', e.currentTarget).spin({color: '#000'});
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
        // Change header login link to logout link
        this.$('.logout-btn').show();
        this.$('.login-btn').hide();

        // Hide the login modal if it's showing
        this.$('#loginModal').modal('hide');

        // show the catalog
        this.$('.catalog-block .catalog').css('visibility', 'visible');


    },

    /**
     * Render adjustments to this layout when the user logs-out
     */
    renderLogout: function () {
        this.$('.logout-btn').hide();
        this.$('.login-btn').show();
        this.$('.catalog-block .catalog').css('visibility', 'hidden');
    },

    /**
     * Render the categories navigation
     */
    renderCategoriesNav: function() {
        this.nav = new App.Views['category-nav-view']({categories: this.categories}).render();
    }
});