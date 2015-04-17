App.Views.HomePage = Backbone.View.extend({
    initialize: function (params) {

    },

    events: {
        'remove': 'remove'
    },

    loginTemplate: App.Templates['pages/login'],

    homeTemplate: App.Templates['pages/home-slideshow'],

    render: function () {
        if(_.isEmpty(this.model.attributes)) {
            this.$el.html(this.loginTemplate()).removeClass().addClass('login-page');
        } else {
            this.$el.html(this.homeTemplate()).removeClass().addClass('home-slideshow-page');
        }
        return this;
    }
});