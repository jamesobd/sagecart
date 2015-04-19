App.Models.User = Backbone.Model.extend({
    urlRoot: function () {return 'api/users/' + this.id},

    id: '@me',

    /**
     * Custom login method
     *
     * @param formData
     * @param options
     */
    login: function (formData, options) {
        var loginOptions = _.extend(options ? _.clone(options) : {}, {
            success: function (data) {
                this.set(data);
                this.trigger('login');
                if (options.success) options.success(data);
            }.bind(this)
        });
        app.userXHR = $.postJSON('/api/users/login', JSON.stringify(formData), loginOptions);
    },

    /**
     * Custom logout method
     *
     * @param options
     */
    logout: function (options) {
        options = options ? _.clone(options) : {};
        $.get('/api/users/logout', options);
        this.clear();
        this.trigger('logout');
    }
});