App.Models.User = Backbone.Model.extend({
    urlRoot: function () {return 'api/users/' + this.id},

    id: '@me',

    login: function (formData, options) {
        app.userXHR = $.postJSON('/api/users/login', JSON.stringify(formData), {
            success: function (data) {
                this.set(data);
                console.log('signed in', data);
            }.bind(this),
            error: function (e) {
                var message = _.isObject(e.responseJSON.message) ? _.values(e.responseJSON.message).join('<br>') : e.responseJSON.message;
                console.log('problem logging in', message);
            }.bind(this)
        });
    },

    logout: function (options) {
        $.get('/api/users/logout', options);
        this.clear();
    }
});