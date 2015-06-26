App.Collections.Categories = Backbone.Collection.extend({
    initialize: function (products, options) {
        this.XHR = $.Deferred();
        this.listenTo(options.user, 'login', function () {
            this.fetch({
                success: function () {
                    // Remove the models that are not web enabled categories
                    this.remove(this.filter(function (product) {
                        return product.get('categoryenabled') != 'true';
                    }));

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
    },

    /**
     * Get the nested structure of the categories with children
     */
    getNestedStructureJSON: function (maxDepth) {
        maxDepth = maxDepth ? maxDepth : 3;
        var currentDepth = 0;

        // Recursive function for building nested category structure with children
        var recursiveCategoryBuild = function (currentCategory) {
            // If the maximum depth is exceeded then exit recursion
            if(++currentDepth > maxDepth) return;

            this.getMainNavigation().forEach(function (category) {
                if (_.isArray(category.get('parentcategory')) && category.get('parentcategory').indexOf(currentCategory.category) > -1) {
                    var childCategory = category.toJSON();
                    childCategory.children = [];
                    currentCategory.children.push(childCategory);
                    recursiveCategoryBuild(childCategory);
                    currentDepth--;
                }
            }.bind(this));
        }.bind(this);

        var nestedCategories = {category: '', children: []};
        recursiveCategoryBuild(nestedCategories);
        return nestedCategories;
    }
});