App.Views.ProductListCartItemView = Backbone.View.extend({
    initialize: function () {
        this.listenTo(this.model, 'change:_Quantity', this.render);
    },
    template: App.Templates['product-list-cart-item'],

    tagName: 'li',

    attributes: {
        class: 'item'
    },

    events: {
        'remove': 'remove',
        'saveProduct': 'updateProduct',
        'click .update': 'updateProduct',
        'click .remove': 'removeProduct',
        "keydown input[name='quantity']": "validateChange",
        "keypress input[name='quantity']": "validateQuantity",
        "keyup input.quantity": "showUpdateButton"
        //"keyup input[name='quantity']": "quantityChanged",
        //"blur input[name='quantity']": "quantityChanged2"
    },

    render: function () {
        var data = _.defaults(this.model.toJSON(), {
            '_Pallets': this.model.getPalletTotal(),
            '_Total': this.model.getTotal()
        });
        this.$el.html(this.template(data));
        return this;
    },

    updateProduct: function () {
        this.model.set("_Quantity", Number(this.$('input[name="quantity"]').val()));
    },

    removeProduct: function () {
        this.model.set("_Quantity", 0);
    },

    showUpdateButton: function (e) {
        if (Number($(e.target).val()) != this.model.get('_Quantity')) {
            this.$('.update').show();
        } else {
            this.$('.update').hide();
        }
    },

    quantityChanged2: function (e) {
        // Update the quantity to match the order increment - always round up
        // Ex. if order inc is 7, if 3 is entered, 7 - (3 mod 7) = 4, so 3 + 4 = 7
        var orderIncrement = this.model.get('OrderIncrement');
        var quantityInCart = this.model.get('_Quantity');
        if (quantityInCart == undefined) {
            quantityInCart = 0;
        }

        // Make sure an order increment doesn't adjust us above the max quantity
        var maxQuantity = 99999999;
        if (orderIncrement) {
            var value = $(e.target).val();
            var mod = value % orderIncrement;
            if (mod != 0) {
                var newValue = Number(value) + (orderIncrement - mod); // prev value plus what remains to fill the increment
                if (newValue.length > (maxQuantity - quantityInCart)) {
                    newValue = math.floor((maxQuantity - quantityInCart) / orderIncrement) * orderIncrement
                }
                $(e.target).val(newValue);
            }
        }

        // Update the pallet quantity
        if (this.model.get("UDF_IT_PER_PALLET") > 0) {
            this.$('.pallet-quantity').html(Number($(e.target).val() / this.model.get('UDF_IT_PER_PALLET')).toFixed(2));
        }

        // Update the total pallet quantity
        var amount = 0;
        var palletsArray = $('.pallet-quantity');
        for (var index = 0; index < palletsArray.length; index++) {
            amount += Number(palletsArray[index].innerHTML);
        }
        $('.pallets-to-add').html(String(amount.toFixed(2)));
        $('.new-total-pallets').html((amount + this.model.getPalletTotal()).toFixed(2));
    },
    validateChange: function (e) {
        var key = e.which;

        return ((((key >= 48 && key <= 57) // Regular number locations
            || (key === 190 // Regular decimals
            || key === 110) // and keypad decimals
            && this.model.get('UDF_DECIMALS_ALLOWED')) // If allowed for this item
            && !e.shiftKey) // And not shift key
            || key >= 96 && key <= 105) // Keypad number locations
            || key === 8 // Backspace
            || key === 46 // Delete
            || key === 9 // Tab
            || key === 37 // Left arrow
            || key === 39 // Right arrow
            || e.ctrlKey && key === 90 // Ctr-Z (undo)
            || key === 27;
    },
    validateQuantity: function (e) {
        // TODO: Limit digits after decimal
        // TODO: insert the character into the correct position of value.
        // TODO: See: http://stackoverflow.com/questions/2897155/get-cursor-position-in-characters-within-a-text-input-field
        var num = Number(e.target.value + "" + String.fromCharCode(e.which));
        return this.model.validQuantity(num);
    }
});