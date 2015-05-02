App.Models.Product = Backbone.Model.extend({
    idAttribute: 'itemcode',
    initialize: function () {
        this.on('change:_Quantity', this.saveQuantity);
    },

    saveQuantity: function () {
        this.save(this.changed, {patch: true});
        this.collection.trigger('change:_Quantity');
    },

    getPalletTotal: function () {
        var quantity = isNaN(Number(this.get('_Quantity'))) ? 0 : Number(this.get('_Quantity'));
        var perPallet = isNaN(Number(this.get('UDF_IT_PER_PALLET'))) ? 0 : Number(this.get('UDF_IT_PER_PALLET'));
        return quantity * perPallet;
    },

    getTotal: function () {
        var quantity = isNaN(Number(this.get('_Quantity'))) ? 0 : Number(this.get('_Quantity'));
        var customerPrice = isNaN(Number(this.get('CustomerPrice'))) ? 0 : Number(this.get('CustomerPrice'));
        return quantity * customerPrice;
    },

    validate: function (attrs, options) {
        var errors = {};
        if (!this.validQuantity(attrs._Quantity)) {
            errors['_Quantity'] = "The quantity is not valid";
        }

        // If there are errors we return it
        if (!_.isEmpty(errors)) {
            return errors;
        }
    },

    validQuantity: function (num) {
        return num < 99999999 && num >= 0;
    }
});