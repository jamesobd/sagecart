App.Views['category-nav-view'] = Backbone.View.extend({
    initialize: function (params) {
        this.categories = params.categories;
    },

    el: '#category-nav',

    events: {
        'remove': 'remove',
        'mouseover .submenu .has-submenu': 'subMenuOpen',
        'mouseleave .submenu .has-submenu': 'subMenuClose'
    },

    template: App.Templates['category-nav'],

    render: function () {
        this.$el.html(this.template(this.categories.getNestedStructureJSON()));
        return this;
    },

    remove: function (e) {
        e.stopPropagation();
        Backbone.View.prototype.remove.call(this);
    },

    subMenuOpen: function (e) {
        this.$('.submenu .offer .col-1 p').hide();
        $('.sub-submenu', e.currentTarget).css({top: -$(e.currentTarget).position().top + "px"}).show();
    },

    subMenuClose: function (e) {
        $('.sub-submenu', e.currentTarget).hide();
        this.$('.submenu .offer .col-1 p').show();
    }
});