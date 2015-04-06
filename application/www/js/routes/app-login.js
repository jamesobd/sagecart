App.Routes.Login = Backbone.Router.extend({
    initialize: function(options) {
        var loginForm = new App.Views.LoginFormView();
    }
});

$(function () {
    var app = new App.Routes.Login();
    Backbone.history.start({pushState: true});
});


