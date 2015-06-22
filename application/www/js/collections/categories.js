App.Collections.Categories = Backbone.Collection.extend({
    initialize: function (products, options) {
        this.XHR = $.Deferred();
        this.listenTo(options.user, 'login', function () {
            this.fetch({
                success: function () {
                    this.XHR.resolve();
                }.bind(this),
                error: function () {
                    this.XHR.reject();
                }.bind(this), reset: true
            })
        }.bind(this));
    },

    url: '/api/categories',

    model: App.Models.Category,

    /**
     * Get all of the categories that are web enabled
     *
     * @param [offset] Number
     * @param [limit] Number
     * @returns Array
     */
    getWebEnabled: function (offset, limit) {
        return _.paginate(this.filter(function (product) {
            return product.get('categoryenabled') == 'true';
        }), offset, limit);
    },

    /**
     * Get the categories that belong to the main product navigation
     *
     * @param [offset] Number
     * @param [limit] Number
     * @returns Array
     */
    getMainNavigation: function (offset, limit) {
        return _.paginate(this.filter(function (product) {
            return product.get('mainnavigation') == 'true';
        }), offset, limit);
    },

    /**
     * Get the categories that have a given parent
     *
     * @param parent String
     * @param [offset] Number
     * @param [limit] Number
     * @returns Array
     */
    getByParent: function (parent, offset, limit) {
        return _.paginate(this.filter(function (product) {
            return product.get('parentcategory').indexOf(parent) > -1;
        }), offset, limit);
    }
});