App.Views['gallery-grid-list'] = Backbone.View.extend({
    initialize: function (params) {
        this.products = app.products;
        this.categories = app.products;
        this.$el.addClass('gallery-widget');
    },

    events: {
        'remove': 'remove'
    },

    template: App.Templates['lists/gallery-grid-list'],

    render: function () {
        // TODO: Remove the slices once we are using categories
        this.$el.html(this.template({products: this.products.toJSON().slice(-10), categories: this.categories.toJSON().slice(-10)}));
        this.enableScripts();
        return this;
    },

    remove: function (e) {
        e.stopPropagation();
        this.gallery.destroy();
        Backbone.View.prototype.remove.call(this);
    },

    enableScripts: function () {
        /*Gallery Filtering and Responsiveness Function
         *******************************************/
        var gallery = (function ($) {
            'use strict';

            var $grid = this.$('.gallery-grid');
            var $filterOptions = this.$('.filters');
            var $sizer = $grid.find('.shuffle__sizer');

            var init = function () {

                    // None of these need to be executed synchronously
                    setTimeout(function () {
                        listen();
                        setupFilters();
                    }, 100);

                    // instantiate the plugin
                    $grid.shuffle({
                        itemSelector: '.gallery-item',
                        sizer: $sizer
                    });
                },

            // Set up button clicks
                setupFilters = function () {
                    var $btns = $filterOptions.children();
                    $btns.on('click', function (e) {
                        var $this = $(this),
                            isActive = $this.hasClass('active'),
                            group = $this.data('group');
                        $('.filters .active').removeClass('active');
                        $this.addClass('active');

                        // Filter elements
                        $grid.shuffle('shuffle', group);
                        e.preventDefault();
                    });

                    $btns = null;
                },

                listen = function () {
                    var debouncedLayout = $.throttle(300, function () {
                        $grid.shuffle('update');
                    });

                    // Get all images inside shuffle
                    $grid.find('img').each(function () {
                        var proxyImage;

                        // Image already loaded
                        if (this.complete && this.naturalWidth !== undefined) {
                            return;
                        }

                        // If none of the checks above matched, simulate loading on detached element.
                        proxyImage = new Image();
                        $(proxyImage).on('load', function () {
                            $(this).off('load');
                            debouncedLayout();
                        });

                        proxyImage.src = this.src;
                    });

                    // Because this method doesn't seem to be perfect.
                    setTimeout(function () {
                        debouncedLayout();
                    }, 500);
                };

            return {
                init: init
            };
        }.call(this, jQuery));

        gallery.init();
        this.gallery = this.$('.gallery-grid').lightGallery({speed: 400});
    }
});