App.Models.Contact = Backbone.Model.extend({
    urlRoot: function () {return 'api/contacts/' + this.id},
    id: '@me',
    login: function (formData, options) {
        $.postJSON('/api/contacts/login', JSON.stringify(formData), options);
    }
});