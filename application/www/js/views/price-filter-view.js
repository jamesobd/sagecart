App.Views['price-filter-view'] = Backbone.View.extend({
    initialize: function (params) {
        this.products = app.products;
    },

    events: {
        'remove': 'remove'
    },

    template: App.Templates['price-filter'],

    render: function () {
        var category = $.getSegment(1) == 'categories' ? $.getSegment(2) : '';
        var products = this.products.getByCategory(category);

        // Render the template
        this.$el.html(this.template());

        // Initialize javascript

        //Price Slider Range
        if (this.$('#price-range').length > 0) {
            var startMin = $.getParam('minPrice') ? Number($.getParam('minPrice')) : Number(this.$('#minPrice').val());
            var startMax = $.getParam('maxPrice') ? Number($.getParam('maxPrice')) : Number(this.$('#maxPrice').val());
            var rangeMax = products ? _.max(products, function(item){return item.get('standardunitprice')}).get('standardunitprice') : this.products.max(function(item){return item.get('standardunitprice')}).get('standardunitprice');

            this.$('#price-range').noUiSlider({
                range: {
                    'min': Number(this.$('#minPrice').attr('data-min-val')),
                    'max': rangeMax
                },
                start: [startMin, startMax],
                connect: true,
                serialization: {
                    lower: [
                        $.Link({
                            target: this.$('#minPrice'),
                            format: {
                                decimals: 0
                            }
                        })
                    ],
                    upper: [
                        $.Link({
                            target: this.$('#maxPrice'),
                            format: {
                                decimals: 0
                            }
                        })
                    ]
                }
            });

            this.$('#price-range').on('set', function () {
                // Update the URL
                $.setParam('minPrice', this.$('#minPrice').val());
                $.setParam('maxPrice', this.$('#maxPrice').val());
            }.bind(this));
        }

        return this;
    }
});