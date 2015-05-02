App.Models.User = Backbone.Model.extend({
    initialize: function () {
        this.XHR = $.Deferred();
        this.fetch({
            success: function () {
                this.XHR.resolve();
                this.trigger('login');
            }.bind(this),
            error: function () {
                this.XHR.reject();
                this.trigger('logout');
            }.bind(this)
        });
    },

    urlRoot: function () {return '/api/users/' + this.id},

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
            }.bind(this),
            error: function(data) {
                this.trigger('logout');
                if (options.error) options.error(data);
            }.bind(this)
        });
        this.XHR = $.postJSON('/api/users/login', JSON.stringify(formData), loginOptions);
    },

    /**
     * Custom logout method
     *
     * @param options
     */
    logout: function (options) {
        options = options ? _.clone(options) : {};
        this.XHR = $.Deferred().reject();
        this.clear();
        $.get('/api/users/logout', options);
        this.trigger('logout');
    }
});