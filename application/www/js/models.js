// Setup a spinner
var target = document.getElementsByTagName('body');
var spinner = new Spinner({position:'fixed'});

/*******************************************************************************
 * Create the App namespace to stick our variables in
 ******************************************************************************/
window.App = {}; // The App namespace
App.Models = {}; // List of Model classes
App.Collections = {}; // List of Collection classes
App.Views = {}; // List of View classes


/*******************************************************************************
 * Models
 ******************************************************************************/

App.Models.Address = Backbone.Model.extend({
    defaults: {
        "ShipToCode": '',
        "ShipToName": '',
        "ShipToAddress1": '',
        "ShipToAddress2": '',
        "ShipToAddress3": '',
        "ShipToCity": '',
        "ShipToState": '',
        "ShipToZipCode": '',
        "ShipToCountryCode": ''
    }
});

App.Models.Contact = Backbone.Model.extend({
    urlRoot: '/ajax/getcontactinfo',
    parse: function (response) {
        var shipToAddresses = []; // Initialize the ship to addresses object.
        for (var index in response['ShipToAddresses']) shipToAddresses.push(new App.Models.Address(response['ShipToAddresses'][index])); // Convert the addresses to Backbone models.
        response['ShipToAddresses'] = shipToAddresses; // Put the backbone addresses in the response.
        return response; // Send the response.
    },
    defaults: {
        "ShipToAddresses": [new App.Models.Address()]
    },
    getAddress: function () {
        // Look at the array of shipping addresses and get Freight Info based on the primary ship to code
        if (this.get('ShipToAddresses').length > 0) {
            return _.find(this.get('ShipToAddresses'), function(address) {
                return address.get('ShipToCode') == App.contact.get('shipToCode');
            })
        }
    }
});

App.Models.Product = Backbone.Model.extend({
    idAttribute: "ItemCode",
    initialize: function (product, category) {
        this.set('CustomerPrice', Number(this.get('CustomerPrice'))); // Format the CustomerPrice.
        //this.set('_PriceTableMultiple', this.get('PriceTable').length > 1); // Store a flag indicating whether there are multiple price points.
        this.set('OrderIncrement', Number(this.get('OrderIncrement'))); // Convert the order increment to a number.
        if (category != undefined && category[0]) this.set('_CategoryCode', category[0]);
        var code = this.get('ItemCode'); // Save the code for the following enclosure.
        var found = App.products.find(function (item) {
            return item.get('ItemCode') === code;
        }); // See if the product is already in the product list.
        if (!found) App.products.add(this); // If the product is new, add it to the list.
        this.on('change:_Quantity', this.updateTotal);
    },
    updateTotal: function () {
        this.set("ItemTotalPrice", (this.get("_Quantity") * this.get("CustomerPrice")));
    }
});

App.Models.Category = Backbone.Model.extend({
    idAttribute: "CategoryCode",
    initialize: function () {
        this.set('Products', new App.Collections.Products(this.get('Products'), [this.get('CategoryCode')])); // Create the Products collection
        this.set('Children', new App.Collections.Categories(this.get('Children'))); // Create the children collection
    }
});

App.Models.Body = Backbone.Model.extend({
    initialize: function () {
        _.bindAll(this);
    },
    defaults: {
        '_PageOption': 100
    },
    setProducts: function (products, type) {
        this.set({
            'Products': products,
            '_Type': type,
            '_Previous': false,
            '_Next': false,
            '_CurrentPage': 1
        });
    }
});

App.Models.Catalog = Backbone.Model.extend({
    defaults: function () {
        return {
            Products: new App.Collections.Products(),
            Children: new App.Collections.Categories()
        };
    },
    parse: function (response) {
        return {categories: new App.Collections.Categories(response)};
    },
    initialize: function () {
        _.bindAll(this);
    },
    findCategory: function (categories, categoryCode) {
        for (var i = 0; i < categories.length; i++) {
            if (categories.at(i).get('CategoryCode') === categoryCode) { // Check to see if the category code matches.
                return categories.at(i); // Return the matching category.
            }
            if (typeof categories.at(i).get('Children') !== 'undefined') { // Check for Children.
                var children = categories.at(i).get('Children'); // Get the Children of the current category.
                var result = App.catalog.findCategory(children, categoryCode); // Recursively call findCategory with the children.
                if (result)
                    return result; // If the recursive call is found, return the result.
            }
        }
        return false; // If we make it here, the category was not found.
    },
    getCategoryInfo: function (categoryCode) {
        if (this.get('categories')) {
            var category = this.findCategory(this.get('categories'), categoryCode); // Find the category with the products to display.
            return category; // Return the collection of products.
        }
    }
});


App.Models.Cart = Backbone.Model.extend({
    urlRoot: "/ajax/getcart",
    initialize: function () {
        _.bindAll(this);
        this.listenTo(this, "change:SalesOrder", this.updateHeader);
    },
    parse: function (response) {
        response['SalesOrder'] = new App.Collections.Products(response['SalesOrder']); // Create the SalesOrder collection
        return response;
    },
    sync: function (method, model, options) {
        if (method === "create" || method === "update")
            options.url = "/ajax/updatecart"; // If the cart is being updated, use the correct url.

        return Backbone.sync(method, model, options); // Call the base method so everything else works as expected.
    },
    saveCart: function () {
        startSpin(document.body);
        this.save(null, {
            success: function () {
                App.mascart.fetch({
                    success: function () {
                        App.cart.trigger("change:SalesOrder"); // Trigger a change event so corresponding views will update.
		                stopSpin();
                    },
                    error: function () {
						stopSpin();
                        console.error('Failed to get cart from MAS.');
                    }
                });
            },
            error: function () {
				stopSpin();
                console.error('Failed to save cart.');
            }
        });
    },
    addComment: function (comment) {
        var commentProduct = App.cart.get("SalesOrder").find(function (model) {
            return model.get('ItemCode') == '/C'
        });

        if (commentProduct == undefined) {
            commentProduct = new App.Models.Product({'ItemCode': '/C', '_Quantity': 1});
        }

        // Update the comment text and then add it to the SalesOrder
        commentProduct.set('CommentText', comment);
        this.get("SalesOrder").add(commentProduct);

        startSpin(document.body);
        this.save(null, {
            success: function (model, response, options) {
                $.ajax({
                    url: 'ajax/submitCart',
                    success: function () {
                        window.location.href = 'confirm';
                    },
                    error: function () {
                        alert('Failed to submit cart.  Please try again or contact us.');

                        // Should we log an error here?
						stopSpin();
                    }
                });
            },
            error: function () {
                alert('Failed to submit cart information.  Please try again or contact us.');
                stopSpin();
            }
        });
    },
    removeFromCart: function (product) {
        var prodInCart = this.get("SalesOrder").filter(function (salesOrderProduct) {
            return product.get('ItemCode') === salesOrderProduct.get('ItemCode');
        })[0]; // Get the specified product from the cart.
//        prodInCart.unset("_Remove");
//        prodInCart.unset("_Update"); // Reset the link states.
//        prodInCart.unset("_NewQuantity"); // Reset the new quantity value.
//        prodInCart.unset("_NewVisibleQuantity"); // Reset the new visible quantity value.
        if (typeof prodInCart !== "undefined") { // Make sure the product exists in the cart.
            product.unset("_PalletQuantity"); // Remove the quantity from the product (in case it is used in the future).
            product.unset("_Quantity"); // Remove the quantity from the product (in case it is used in the future).
//            product.unset("_VisibleQuantity"); // Remove the visible quantity from the product (in case it is used in the future).
            this.get("SalesOrder").remove(product); // Remove the product from the cart.
        }

		startSpin(document.body);
        this.save(null, {
            success: function (model, response, options) {
                App.mascart.fetch({
                    success: function (model, response, options) {
                        if (_.isEmpty(response.resource)) {
                            App.mascart.clear();
                        }
                        App.cart.trigger("change:SalesOrder"); // Trigger a change event so corresponding views will update.
						stopSpin();
                    },
                    error: function() {
                        stopSpin();
                        console.error('Failed to get cart from MAS');
                    }
                });
            },
            error: function() {
                stopSpin();
                console.error('Failed to save cart');
            }
        });
    },
    calculateCartItems: function () {
        var amount = 0;
        var number = 0; // Initialize the cart amount and number of items.

        var products = this.get("SalesOrder"); // Retrieve the list of products.

        if (products) { // Make sure the list exists.
            for (var index = 0; index < products.length; index++) {
                if (!isNaN(products.at(index).get('CustomerPrice')) && products.at(index).get('ItemCode') != '/C') {
                    var productNumber = Number(products.at(index).get('_Quantity')); // Get the quantity of the specified product.
                    amount += Number(products.at(index).get('CustomerPrice')) * productNumber;
                    number++; // Increment the number of items in the cart.
                }
            }
        }

        return {amount: amount, number: number};
    },
    calculateTotalPallets: function () {
        var amount = 0;

        var products = this.get("SalesOrder"); // Retrieve the list of products.

        if (products) { // Make sure the list exists.
            for (var index = 0; index < products.length; index++) {
                if (!isNaN(products.at(index).get('CustomerPrice')) && products.at(index).get('ItemCode') != '/C') {
                    amount += Number(products.at(index).get('_PalletQuantity'));
                }
            }
        }

        return math.round(amount,2);
    },
    updateHeader: function (e) {
        var items = this.calculateCartItems();

        this.set({
            '_CartAmount': items.amount.toFixed(2), // Save the cart amount to the model attributes.
            '_CartItems': String(items.number) + ((items.number === 1) ? " item" : " items") // Save the number of cart items to the model attributes.
        });

        if ($('.product-list.cart-list').length) App.productView.renderSearch();
    },
    updateQuantity: function (product, qty) {
        var prodInCart = this.get("SalesOrder").get(product); // Get the current product in the cart.
//        prodInCart.unset("_Remove");
        prodInCart.unset("_Update"); // Reset the link state.

        // If there is an order increment then we must multiply the visible quantity by it
//        var orderIncrement = Number(prodInCart.get('OrderIncrement'));
//        if (isNaN(orderIncrement) || orderIncrement === 0) {
//            prodInCart.set("_NewQuantity", qty); // Track the new quantity value.
//            prodInCart.set("_NewVisibleQuantity", qty); // Track the new visible quantity value.
//        } else {
//            prodInCart.set("_NewQuantity", qty * orderIncrement); // Track the new quantity value x.
//            prodInCart.set("_NewVisibleQuantity", qty); // Track the new visible quantity value x.
//        }
//
//        if (qty < 1)
//            prodInCart.set("_Remove", true); // Display the remove link on the product.
//        else if (qty != prodInCart.get("_VisibleQuantity"))
//            prodInCart.set("_Update", true); // Display the update link on the product.
//        else {
//            prodInCart.unset("_NewQuantity"); // The new quantity isn't needed because it matches the old quantity.
//            prodInCart.unset("_NewVisibleQuantity"); // The new visible quantity isn't needed because it matches the old quantity.
//        }

        this.get("SalesOrder").add(prodInCart); // Add the product to update the quantity for the cart.
        this.trigger("change:SalesOrder"); // Trigger a change event so corresponding views will update.
        //this.save(); // Synchronize the cart with the server.
    },
    processUpdate: function (product) {
//        var prodInCart = this.get("SalesOrder").get(product); // Get the current product in the cart.
//        prodInCart.set("_Quantity", prodInCart.get("_NewQuantity")); // Put the new quantity in as the quantity.
//        prodInCart.set("_VisibleQuantity", prodInCart.get("_NewVisibleQuantity")); // Put the new visible quantity in as the quantity.
//        prodInCart.set("ItemTotalPrice", (prodInCart.get("_Quantity") * prodInCart.get("CustomerPrice"))); // Put the new visible quantity in as the quantity.
//        prodInCart.unset("_Update"); // Reset the link state.
//
//        // If there is an order increment then we must multiply the visible quantity by it
////        var orderIncrement = Number(prodInCart.get('OrderIncrement'));
////        if (isNaN(orderIncrement) || orderIncrement === 0) {
////            prodInCart.set("_NewQuantity", qty); // Track the new quantity value.
////            prodInCart.set("_NewVisibleQuantity", qty); // Track the new visible quantity value.
////        } else {
////            prodInCart.set("_NewQuantity", qty * orderIncrement); // Track the new quantity value x.
////            prodInCart.set("_NewVisibleQuantity", qty); // Track the new visible quantity value x.
////        }
////
////        if (qty < 1)
////            prodInCart.set("_Remove", true); // Display the remove link on the product.
////        else if (qty != prodInCart.get("_VisibleQuantity"))
////            prodInCart.set("_Update", true); // Display the update link on the product.
////        else {
////            prodInCart.unset("_NewQuantity"); // The new quantity isn't needed because it matches the old quantity.
////            prodInCart.unset("_NewVisibleQuantity"); // The new visible quantity isn't needed because it matches the old quantity.
////        }
//
//        this.get("SalesOrder").add(prodInCart); // Add the product to update the quantity for the cart.
//        this.trigger("change:SalesOrder"); // Trigger a change event so corresponding views will update.
//        //this.save(); // Synchronize the cart with the server.
//    },
//    processUpdate: function (product) {
////        var prodInCart = this.get("SalesOrder").get(product); // Get the current product in the cart.
////        prodInCart.set("_Quantity", prodInCart.get("_NewQuantity")); // Put the new quantity in as the quantity.
////        prodInCart.set("_VisibleQuantity", prodInCart.get("_NewVisibleQuantity")); // Put the new visible quantity in as the quantity.
////        prodInCart.set("ItemTotalPrice", (prodInCart.get("_Quantity") * prodInCart.get("CustomerPrice"))); // Put the new visible quantity in as the quantity.
////        prodInCart.unset("_Update"); // Reset the link state.
//        prodInCart.unset("_NewQuantity"); // The new quantity isn't needed since we've completed the update.
//        prodInCart.unset("_NewVisibleQuantity"); // The new visible quantity isn't needed since we've completed the update.

		startSpin(document.body);
        this.save(null, {
            success: function (model, response, options) {
                App.mascart.fetch({
                    success: function (model, response, options) {
                        App.cart.trigger("change:SalesOrder"); // Trigger a change event so corresponding views will update.
                        stopSpin();
                    },
                    error: stopSpin()
                });
            },
            error: stopSpin
        });
    }
});


App.Models.MasCart = Backbone.Model.extend({
    urlRoot: '/ajax/getmascart',
    parse: function (response, options) {
        return response.resource;
    }
});


/*******************************************************************************
 * Collections
 ******************************************************************************/
/**
 * The product collection
 */
App.Collections.Products = Backbone.Collection.extend({
    model: function (attrs, options) {
        return new App.Models.Product(attrs, options);
    },
    getCart: function () {
        return new App.Collections.Products(this.filter(function (product) {
            return product.get('_Quantity') > 0;
        }));
    },
    findProduct: function (searchString, searchFields) {
        var resultArray = new Array(); // Start building the array of Products.
        var searchRegex = new RegExp(searchString.replace(/ /g, "|"), "i"); // Define the search regex string.

        var products = this; // Retrieve the products.
        if (products.length > 0) { // Make sure there are products before proceeding.
            for (var productIndex = 0; productIndex < products.length; productIndex++) {
                var found = false; // Default is that the product is not found.
                for (var searchFieldIndex = 0; searchFieldIndex < searchFields.length; searchFieldIndex++) { // Check each search field.
                    if (products.at(productIndex).get(searchFields[searchFieldIndex]).search(searchRegex) > -1) {
                        found = true; // Found - the product needs to be part of the results.
                    }
                }

                if (found)
                    resultArray.push(products.at(productIndex));
            }
        }

        return new App.Collections.Products(resultArray); // Return the result collection of products.
    },
    getProductList: function (categoryCode) {
        if (categoryCode == undefined) {
            return new App.Collections.Products(this.filter(function (product) {
                return true;
            }));
        } else {
            return new App.Collections.Products(this.filter(function (product) {
                return product.get('_CategoryCode') === categoryCode;
            }));
        }
    }
});

/**
 * The category collection
 */
App.Collections.Categories = Backbone.Collection.extend({
    model: function (attrs, options) {
        return new App.Models.Category(attrs, options);
    }
});


/*******************************************************************************
 * Views
 ******************************************************************************/
App.Views.ProductListItemView = Backbone.View.extend({
    tagName: "li",
    className: "clearfix",
    template: Handlebars.compile($("#product-listitem").html()), // Define the template to use for the rendering.
    initialize: function () {
//        this.listenTo(this.model, "all", this.render); // Re-render any time the model changes.
        this.on("saveProduct", this.addButtonClicked, this);
    },
    render: function () {
        this.$el.html(this.template(this.model.toJSON())); // Render the model based on the specified template.
        return this;
    },
    events: {
        "keydown input[name='quantity']": "validateChange",
        "keypress input[name='quantity']": "validateNumberWithMax",
        "change input[name='quantity']": "quantityChanged",
        "keyup input[name='quantity']": "quantityChanged",
        "blur input[name='quantity']": "quantityChanged2",
        "saveProduct": "addButtonClicked"
    },
    addButtonClicked: function (e) {
        var quantity = Number($(e.target).find('input[name="quantity"]').val());

        // If no quantity is specified then just return
        if (quantity < 1) return;

        // Update the quantity
        if (this.model.get("_Quantity")) {
            this.model.set("_Quantity", Number(this.model.get("_Quantity")) + quantity);
        } else {
            this.model.set("_Quantity", Number(quantity));
        }

        // Update the pallet quantity
        if (this.model.get("_PalletQuantity")) {
            this.model.set("_PalletQuantity", Number(this.model.get("_PalletQuantity")) + Number($(e.target).find('.pallet-quantity').html()).toFixed(2));
        } else {
            this.model.set("_PalletQuantity", Number($(e.target).find('.pallet-quantity').html()).toFixed(2));
        }

        // Refresh this view
        this.render();

        // Add the product to the SalesOrder, merging values if the model is already in the SalesOrder.
        App.cart.get("SalesOrder").add(this.model, {merge: true});
    },
    quantityChanged: function (e) {
        // Update the pallet quantity
        this.$('.pallet-quantity').html(Number($(e.target).val() / this.model.get('UDF_IT_PER_PALLET')).toFixed(2));

        // Update the total pallet quantity
        var amount = 0;
        var palletsArray = $('.pallet-quantity');

        for (var index = 0; index < palletsArray.length; index++) {
            amount += Number(palletsArray[index].innerHTML);
        }
        $('.pallets-to-add').html(String(amount.toFixed(2)));
        $('.new-total-pallets').html((amount + App.cart.calculateTotalPallets()).toFixed(2));
    },
    quantityChanged2: function (e) {
        // Update the quantity to match the order increment - always round up
        // Ex. if order inc is 7, if 3 is entered, 7 - (3 mod 7) = 4, so 3 + 4 = 7
        var orderIncrement = this.model.get('OrderIncrement');
        var quantityInCart = this.model.get('_Quantity');
        if (quantityInCart == undefined) {
            quantityInCart = 0;
        }
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
        this.$('.pallet-quantity').html(Number($(e.target).val() / this.model.get('UDF_IT_PER_PALLET')).toFixed(2));

        // Update the total pallet quantity
        var amount = 0;
        var palletsArray = $('.pallet-quantity');

        for (var index = 0; index < palletsArray.length; index++) {
            amount += Number(palletsArray[index].innerHTML);
        }
        $('.pallets-to-add').html(String(amount.toFixed(2)));
        $('.new-total-pallets').html((amount + App.cart.calculateTotalPallets()).toFixed(2));
    },
    validateChange: function (e) {
        //TODO: Combine this with the one in the cart and make it an external function
        var quantityInCart = this.model.get('_Quantity');
        if (quantityInCart == undefined) {
            quantityInCart = 0;
        }
        var key = e.keyCode;

        if (((((key >= 48 && key <= 57) || (key === 190 || key === 110) && this.model.get('UDF_DECIMALS_ALLOWED')) && (!e.shiftKey)) // Regular number locations, ".", and not shift key.
            || (key >= 96 && key <= 105)) // Keypad number locations.
            || key === 8 || key === 46 || key === 9 || key === 37 || key === 39  // Backspace, Delete, Tab, Left, and Right
            || (e.ctrlKey && key === 90) || key === 27) // Undo, Escape
        {
            // TODO: Trigger message to user if they attempted to type more than allowed amount
            return true; // Valid number/character is used.
        }

        return false; // Invalid character used.
    },
    validateQuantity: function(e) {
        var maxQuantity = 99999999;
        var val = Number(e.target.value + "" + String.fromCharCode(e.which));
            return val < maxQuantity && val >= 0;
        }
});

App.Views.ProductListCartItemView = Backbone.View.extend({
    tagName: "li",
    className: "clearfix",
    template: Handlebars.compile($("#product-cartlistitem").html()), // Define the template to use for the rendering.
    initialize: function () {
        this.listenTo(this.model, "all", this.render); // Re-render any time the model changes.
    },
    render: function () {
        this.$el.html(this.template(this.model.toJSON())); // Render the model based on the specified template.
        return this;
    },
    events: {
        "click .remove-from-cart": "productRemoved",
        "click .update-cart": "productUpdated",
        "change input[name='quantity']": "quantityChanged",
        "keyup input[name='quantity']": "quantityChanged",
        "blur input[name='quantity']": "quantityChanged2",
        "keydown input[name='quantity']": "validateChange",
        "keypress input[name='quantity']": "validateNumberWithMax",
        "click .product-title": "productClicked"
    },
    productRemoved: function (e) {
        App.cart.removeFromCart(this.model); // Remove the product from the cart.
        e.preventDefault();
    },
    productUpdated: function (e) {
        e.preventDefault();
        this.model.set('_Quantity', $(e.target).closest('.item.row').find('.quantity').val());
        this.model.set('_PalletQuantity', $(e.target).closest('.item.row').find('.pallet-quantity').html());

		startSpin(document.body);
        App.cart.save(null, {
            success: function (model, response, options) {
                App.mascart.fetch({
                    success: function (model, response, options) {
                        App.cart.trigger("change:SalesOrder"); // Trigger a change event so corresponding views will update.
                        stopSpin();
                    },
                    error: function() {
                        stopSpin();
                        console.error('Failed to get cart from MAS');
                    }
                });
            },
            error: function() {
                stopSpin();
                console.error('Failed to save cart');
            }
        });
    },
    quantityChanged: function (e) {
        // Update the pallet quantity
        this.$('.pallet-quantity').html(Number($(e.target).val() / this.model.get('UDF_IT_PER_PALLET')).toFixed(2));

        // Hide or show the update cart link
        if ($(e.target).val() != this.model.get('_Quantity')) {
            // show the update link
            this.$('.update-cart').css('visibility', 'visible');
        } else {
            // hide the update link
            this.$('.update-cart').css('visibility', 'hidden');
        }
    },
    quantityChanged2: function (e) {
        // Update the quantity to match the order increment - always round up
        // Ex. if order inc is 7, if 3 is entered, 7 - (3 mod 7) = 4, so 3 + 4 = 7
        var orderIncrement = this.model.get('OrderIncrement');
        var maxQuantity = 99999999;
        if (orderIncrement) {
            var value = $(e.target).val();
            var mod = value % orderIncrement;
            if (mod != 0) {
                var newValue = Number(value) + (orderIncrement - mod); // prev value plus what remains to fill the increment
                if (newValue.length > (maxQuantity)) {
                    newValue = math.floor((maxQuantity) / orderIncrement) * orderIncrement
                }
                $(e.target).val(newValue);
            }
        }

        // Update the pallet quantity
        this.$('.pallet-quantity').html(Number($(e.target).val() / this.model.get('UDF_IT_PER_PALLET')).toFixed(2));

        // Hide or show the update cart link
        if ($(e.target).val() != this.model.get('_Quantity')) {
            // show the update link
            this.$('.update-cart').css('visibility', 'visible');
        } else {
            // hide the update link
            this.$('.update-cart').css('visibility', 'hidden');
        }
    },
    productClicked: function (e) {
        App.bodyModel.setProducts(new App.Collections.Products([this.model]), 'product', 'Product Information');
    },
    validateChange: function (e) {
        //TODO: Combine this with the one in the product list and make it an external function
        var key = e.keyCode;
        if (((((key >= 48 && key <= 57) || (key === 190 || key === 110) && this.model.get('UDF_DECIMALS_ALLOWED')) && (!e.shiftKey)) // Regular number locations and not shift key.
            || (key >= 96 && key <= 105)) // Keypad number locations.
            || key === 8 || key === 46 || key === 9 || key === 37 || key === 39  // Backspace, Delete, Tab, Left, and Right
            || (e.ctrlKey && key === 90) || key === 27) // Undo, Escape
        {
            // TODO: Trigger message to user if they attempted to type more than allowed amount
            return true; // Valid number/character is used.
        }

        // Advance to next field // this doesn't seem to work
        if (e.keyCode == 13) {
            $(e.target).focusout()
        }

        return false; // Invalid character used.
    },
    validateQuantity: function(e) {
        var maxQuantity = 99999999;
        var val = Number(e.target.value + "" + String.fromCharCode(e.which));
        return val < maxQuantity && val >= 0;
    }
});

App.Views.HeaderView = Backbone.View.extend({
    el: '#cart', // For this view, use the element on the page with the id of cart.
    template: Handlebars.compile($("#header-cart-template").html()), // Define the template to use for the rendering.
    initialize: function () {
        this.listenTo(this.model, "all", this.render); // Re-render any time the model changes.
    },
    render: function () {
        this.$el.html(this.template(this.model.toJSON())); // Render the model based on the specified template.
        if ($('#content .cart-list').length > 0) { // If the cart is being displayed, re-render the view.
            this.showCart(); // Retrieve and render the cart html.
        }
        return this;
    },
    events: {
        "click": "showCart"
    },
    showCart: function () {
        App.bodyModel.setProducts(App.products.getCart(), 'cart', 'Shopping Cart');
        $('#product-list-description').html('<h1>Shopping Cart</h1></div>');
    }
});

App.Views.CartInfoView = Backbone.View.extend({
    tagName: "div",
    className: "rightAlign",
    template: Handlebars.compile($("#cart-body-info").html()), // Define the template to use for the rendering.
    initialize: function () {
        this.listenTo(App.cart, "change:SalesOrder", this.render);
    },
    render: function () {

        var locations = App.contact.get('ShipToAddresses'); // Retrieve the locations from the contact.
        var cartTotal = App.cart.calculateCartItems().amount; // Get the cart total amount.
        var shipToCode = App.cart.get("shipToCode"); // Get the current shipping address.
        var shippingLocations; // Initialize the shipping locations.

        // renders the header
//        var type = this.model.get('_Type');
//        if (type == 'cart') {
//        }
        // TODO: Figure out if locations code is still needed and remove it.
        if (locations.length > 1) {
            var jsonLocations = []; // Initialize the json locations.
            for (var index = 0; index < locations.length; index++) {
                var location = locations[index].toJSON();

                // Check to see if the shipping address is the selected one.
                if (location.ShipToCode == shipToCode) {
                    location.selected = true;
                    // add the contact us for freight info line below the "Shopping Cart" title
                    $('#product-list-description').append('<div id="freight-info">' + location.UDF_FREIGHT_INFO + '</div>');
                }

                // Put each json object in the array.
                jsonLocations.push(location);
            }

            shippingLocations = { Multiple: jsonLocations }; // Put the json locations in the final object.
        } // If there are more than one location, specify so.
        else shippingLocations = { Single: [locations[0].toJSON()] }; // If not, show that there is just one single shipping location.

        var address = App.contact.getAddress();
        if (address != undefined) {
            var udfFreightInfo = address.get('UDF_FREIGHT_INFO');
//            App.contact.set('_UDF_FREIGHT_INFO',udfFreightInfo);
            if (udfFreightInfo != undefined) {
                $('#freight-info-desc').html(udfFreightInfo);
            }
        }

        var cartModel = { _CartTotal: cartTotal, _UDF_FREIGHT_INFO: udfFreightInfo }; // Create the cart item to use in the view.
        cartModel = _.extend(cartModel, App.mascart.toJSON());

        // Get the total number of pallets
        var totalPallets = App.cart.calculateTotalPallets();

        if (isNaN(totalPallets)) {
            cartModel._TotalPallets = 0.00;
        } else {
            cartModel._TotalPallets = totalPallets;
        }

        // Calculate total and remove empty fields
        var nonTaxable = Number(cartModel.NonTaxableAmt);
        var taxable = Number(cartModel.TaxableAmt);
        var tax = Number(cartModel.SalesTaxAmt);
        //var discount = cartModel.DiscountAmt;
        var freight = Number(cartModel.FreightAmt);

        var cartTotalFull = nonTaxable + taxable + tax + freight;

        if (isNaN(cartTotalFull)) {
            cartModel.CartTotal = 0.00;
        } else {
            cartModel.CartTotal = cartTotalFull;
        }

        var subTotal = nonTaxable + taxable;

        if (isNaN(subTotal)) {
            cartModel.SubTotal = 0.00;
        } else {
            cartModel.SubTotal = subTotal;
        }

        // remove empty values
        if (nonTaxable == 0 || isNaN(nonTaxable)) {
            cartModel.NonTaxableAmt = 0.00;
        } else {
            cartModel.NonTaxableAmt = nonTaxable;
        }
        if (taxable == 0 || isNaN(taxable)) {
            cartModel.TaxableAmt = 0.00;
        } else {
            cartModel.TaxableAmt = taxable;
        }
        if (tax == 0 || isNaN(tax)) {
            cartModel.SalesTaxAmt = 0.00;
        } else {
            cartModel.SalesTaxAmt = tax;
        }
        if (freight == 0 || isNaN(freight)) {
            cartModel.FreightAmt = 0.00;
        } else {
            cartModel.FreightAmt = freight;
        }

        // Set the cartModel Comment to the comment from the Sales Order

        var waitToSend = function () {
            var defer = Q.defer();
            var timer = setInterval(function () {
                if (App.cart.get("SalesOrder")) {
                    clearInterval(timer);
                    defer.resolve(App.cart.get("SalesOrder"));
                }
            }, 300);
            return defer.promise;
        };

        var that = this;
        return waitToSend().then(function (salesOrder) {
            var comment = salesOrder.find(function (model) {
                return model.get('ItemCode') == '/C'
            });
            if (comment == undefined) {
                cartModel.Comment = '';
            } else {
                cartModel.Comment = comment.get('CommentText');
            }

            that.$el.html(that.template(cartModel)); // Render the view based on the specified template.

            return that;
        });
    },
    events: {
        "keydown #shipping-comments": "limitComments"
    },
    limitComments: function (e) {
        var charsInBox = e.target.value.length;
        var maxQuantity = 2048;
        $('#comments-chars').html(charsInBox + ' of ' + maxQuantity)
        if (e.target.value.length <= (maxQuantity)) {
            return true;
        }
        return false;
    }
});

App.Views.ProductListView = Backbone.View.extend({
    el: '#product-list-wrapper',
    template: Handlebars.compile($("#product-body-header").html()),
    template2: Handlebars.compile($("#pagination-header").html()),
    template3: Handlebars.compile($("#pagination-footer").html()),
    template4: Handlebars.compile($("#product-list-pallets").html()),

    initialize: function () {
        //this.listenTo(this.model, "reset", this.render); // Re-render any time the model changes.
        this.listenTo(this.model, "change", this.renderSearch); // Re-render any time the model changes.
    },
    renderSearch: function () {
        this.$el.empty();
        var type = this.model.get('_Type');

        if (type === 'cart') {
            var products = App.cart.get('SalesOrder'); // Retrieve the products from the  for processing.

            // Reset the menu on the left
            $('#main-nav .active').removeClass('active');
            $('#main-nav .glyphicon-chevron-down').removeClass('glyphicon-chevron-down')
                .addClass('glyphicon-chevron-right').closest('.category').children('ul').hide();
        } else {
            var products = this.model.get('Products'); // Retrieve the products from the  for processing.
        }

        // Pagination setup
        var currentPage = Number(this.model.get('_CurrentPage')); // Retrieve the current page from the model for processing.
        var pageOption = Number(this.model.get('_PageOption')); // Retrieve the page option (number of product in a page) for processing.
        var pages = []; // Initialize the pages for the model.

        var min = (currentPage > 5) ? currentPage - 5 : 1; // Define the min page.
        var max = (Math.ceil(products.length / pageOption) - currentPage > 5) ? currentPage + 5 : Math.ceil(products.length / pageOption); // Define the max page.

        for (var index = min; index <= max; index++) {
            pages.push({_Number: index, _Current: index === currentPage}); // Add the page to the array.
        }

        var previous = false;
        var next = false;
        var previousEllipses = false;
        var nextEllipses = false;
        var numberOfPages = 0;

        if (pages.length > 0 && pages[0].number < this.model.get('_CurrentPage')) previous = true; // Turn on the previous model item as needed.
        if (pages.length > 0 && pages[pages.length - 1].number > this.model.get('_CurrentPage')) next = true; // Turn on the next model item as needed.
        if (pages.length > 0 && pages[0].number > 1) previousEllipses = true; // Turn on the previous ellipses model item as needed.
        if (pages.length > 0 && pages[pages.length - 1].number < Math.ceil(products.length / pageOption)) nextEllipses = true; // Turn on the next ellipses model item as needed.
        if (pages.length > 0) {numberOfPages = pages.length} else {numberOfPages = 0};

        this.model.set({
            '_Pages': pages,
            '_Previous': previous,
            '_Next': next,
            '_PreviousEllipses': previousEllipses,
            '_NextEllipses': nextEllipses,
            '_NumberOfPages': numberOfPages
        }, {silent: true}); // Save model items.

        // Add the show number dropbox
        this.$el.append(this.template({ _Pagination: (type === 'catalog') ? true : false })); // Put in or remove pagination, based on criteria.


        if (type === 'catalog') {

            var palletsInCart = App.cart.calculateTotalPallets();
            this.$el.append(this.template4({_className: 'class=bottom-buttons', _palletsInCart: palletsInCart}));

            // Add the pager above the catalog
            this.$el.append(this.template2(this.model.toJSON())); // Render the pagination area.

        }


        var productUl = $(document.createElement('ul')).attr('id', 'product-list').addClass('product-list').appendTo(this.$el); // Create the product list.

        // Add the Cart/Catalog to the display
        // if the shopping cart is empty.
        if (products.length == 0) {
            productUl.html("<h3 style='text-align: center'>There are currently no items in your shopping cart.</h3>")
        }

        for (var index = pageOption * (currentPage - 1); index < products.length && index < pageOption * currentPage; index++) {
            var product = products.at(index); // Get the product from the collection.
            if (product.get('ItemCode') != '/C') {
                if (type === 'cart') {
                    var nextView = new App.Views.ProductListCartItemView({model: product}); // Define the next product view.
                    productUl.removeClass('catalog-list').addClass('cart-list'); // Define the appropriate class.
                } else if (type === 'product' || type === 'catalog') {
                    var nextView = new App.Views.ProductListItemView({model: product});  // Define the next product view.
                    productUl.removeClass('cart-list').addClass('catalog-list'); // Define the appropriate class.
                }
                productUl.append(nextView.renderSearch().el); // Render the product view and put it in the list view.
            }
        }

        // Either add the cart info on the bottom or add a pager
        if (type === 'cart') {
            var that = this;
            App.cartInfoView.renderSearch().then(function (cartInfoViewRendered) {
                that.$el.append(cartInfoViewRendered.el); // Render the cart view.
            });
        } else if (type === 'catalog') {

            this.$el.append(this.template3(this.model.toJSON())); // Render the pagination area.

            $('#show-page-option').val(this.model.get('_PageOption')); // Make sure the correct page option is selected.
        }

        $('.order-increment-tip').tooltip(
            {
                title: "Item must be ordered in multiples of this quantity",
                placement: "bottom"
            }
        );

        if (type === 'catalog') {
            this.$el.append(this.template4({_className: 'class=bottom-buttons', _palletsInCart: palletsInCart}));
        }

    },
    events: {
        "click #submit-button-init": "finalizePurchase", // This is from CartInfoView
        "click .add-to-cart": "triggerProductSaves", // Trigger each product in the list to save any quantity changes to the cart
//        "change #shipping-location": "shippingChanged", // This is from CartInfoView
        //"change #shipping-comments": "addComment", // This is from CartInfoView
        "change #show-page-option": "pageOptionChanged",
        "click .pagination-previous": "previousClicked",
        "click .pagination-next": "nextClicked",
        "click .pagination-page": "pageClicked"
    },
    triggerProductSaves: function () {
        $('#product-list li').trigger('saveProduct');
        this.renderSearch();
        App.cart.saveCart();
    },
    finalizePurchase: function () { // This is from CartInfoView
        App.cart.addComment($('#shipping-comments').val());
        /*$.ajax({
         url: 'ajax/submitCart',
         success: function () {

         window.location.href = 'confirm';
         },
         error: function () {
         alert('Failed to submit cart please try again or contact us.');
         }
         });*/
    },
//    shippingChanged: function (e) { // This is from CartInfoView
//        App.cart.set('ShipToCode', $(e.target).val());
//
//        startSpin(document.body);
//        App.cart.save(null, {
//            success: function (model, response, options) {
//                App.mascart.fetch({
//                    success: function (model, response, options) {
//                        App.cart.trigger("change:SalesOrder"); // Trigger a change event so corresponding views will update.
//                        stopSpin();
//                    },
//                    error: stopSpin()
//                });
//            },
//            error: stopSpin()
//        });
//    },
//    addComment: function (e) { // This is from CartInfoView
//        App.cart.addComment($(e.target).val()); // Update the quantity on the cart.
//    },
    pageOptionChanged: function (e) {
        this.model.set('_PageOption', e.target.value);
    },
    previousClicked: function () {
        if (this.model.get('_CurrentPage') > 1) this.model.set('_CurrentPage', this.model.get('_CurrentPage') - 1);
    },
    nextClicked: function () {
        if (this.model.get('_CurrentPage') < (this.model.get('Products').length / this.model.get('_PageOption'))) this.model.set('_CurrentPage', this.model.get('_CurrentPage') + 1);
    },
    pageClicked: function (e) {
        var page = Number(e.target.innerText);
        if (page >= 1 && page <= this.model.get('Products').length) this.model.set('_CurrentPage', page);
    }
});
