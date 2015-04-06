App.Views.LoginFormView = Backbone.View.extend({
    el: '#content form[name=login-form]',

    model: new App.Models.Contact(),

    template: '',

    initialize: function () {
        //this.listenTo(this.model, "all", this.render);
    },

    events: {
        'submit': 'validateSubmit'
    },

    validateSubmit: function (e) {
        e.preventDefault();
        // Save the data from the form into the model
        this.model.login(this.$el.serializeObject(), {
            success: function (data) {
                this.$('.alert').hide();
                window.location.href = '/';
            }.bind(this),
            error: function (e) {
                var message = _.isObject(e.responseJSON.message) ? _.values(e.responseJSON.message).join('<br>') : e.responseJSON.message;
                this.$('.alert').html(message).show();
            }.bind(this)
        });
    }
});