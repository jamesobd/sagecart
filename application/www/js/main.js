/*******************************************************************************
 * The App
 ******************************************************************************/
var spinCounter = 0;
var startSpin = function (x) {
    spinCounter++;
    $('.modal-backdrop').css({"display":"block"});
    spinner.spin(x);
}
var stopSpin = function () {
    spinCounter--;
    if (spinCounter == 0) {
        spinner.stop();
        $('.modal-backdrop').css({"display":"none"});
    }
}

$(function () {

    App.bodyModel = new App.Models.Body; // Default Body View.
    App.productView = new App.Views.ProductListView({model: App.bodyModel}); // Default.


    // Get the shopping cart from the server
    App.cart = new App.Models.Cart;
    startSpin(document.body);
    App.cart.fetch({
        success: function (model, response, options) {
            model.get('SalesOrder').each(function (product) {
                App.products.get(product.get('ItemCode')).set(product.toJSON());  // Update the catalog products to have the cart attributes (such as Quantity)
            });
            model.get('SalesOrder').reset(App.products.getCart().models);
            stopSpin();
        },
        error: function() {
            stopSpin();
            console.error('Failed to load cart');
        }
    });

    // Get the mas cart from the mas server
    App.mascart = new App.Models.MasCart;
    startSpin(document.body);
    App.mascart.fetch({
        success: function () {
            App.cart.trigger("change:SalesOrder"); // Trigger a change event so corresponding views will update.
            stopSpin();
        },
        error: function () {
            stopSpin();
        }
    });

    App.cartInfoView = new App.Views.CartInfoView(); // Default.

    App.header = new App.Views.HeaderView({model: App.cart});

    // Nav links
    // Update product list upon category selection
    // Removed delegation since the categories are not changed on load and there is not an overly large number of categories
    $('#main-nav').on('click', 'a.category-nav', function (e) {

        $('a.category-nav').parent('.active').removeClass('active');
        $(this).parent().addClass('active');

        if ($(e.target).attr('id') == 'show-all') {
            // Update the product-list-header
            var category = App.catalog.getCategoryInfo(this.href.substring(this.href.lastIndexOf('/') + 1));
            $('#product-list-description').html('<h1>All Items</h1>');

            // Update the product-list
            App.bodyModel.setProducts(App.products.getProductList(), 'catalog');
        } else {
            // Update the product-list-header
            var category = App.catalog.getCategoryInfo(this.href.substring(this.href.lastIndexOf('/') + 1));
            $('#product-list-description').html('<h1>' + category.get('CategoryCodeDesc') + '</h1>'+category.get('CategoryLongDesc'));

            // Update the product-list
            App.bodyModel.setProducts(App.products.getProductList(this.href.substring(this.href.lastIndexOf('/') + 1)), 'catalog');
        }

        $('#main-nav .category').removeClass('active');
        $(e.target).closest('.category').addClass('active');
    });

    // Menu Collapse code
    $('#main-nav').on('click', 'li.category a', function (e) {
         $(this).closest('.category').children('ul').toggle();
         $(this).find('span.glyphicon').toggleClass('glyphicon-chevron-right').toggleClass('glyphicon-chevron-down');
         e.preventDefault();
    });
    
    // Search field listener
    $('#search-text').on('change', function (e) {
        App.bodyModel.setProducts(App.products.findProduct(this.value, ["ItemCode", "ItemCodeDesc"]), 'catalog');
		$('#product-list-description').html('<h1>' + 'Search Results for "' + this.value + '"</h1>');
        this.value = "";
    });


    // DOM event listeners that need to move to views once there is a view for them
    $('#freight-dialog-link').click(function(e) {
        // Show the freight dialog
        $('#template-modal').modal();
    });

	
//    $('#search-button, #search-logo').on('click', function (e) {
//        App.bodyModel.setProducts(App.products.findProduct($('#search-text').val(), ["ItemCode", "ItemCodeDesc"]), 'catalog');
//		$('#product-list-description').html('<h1>' + 'Search Results for "' + $('#search-text').val() + '"</h1>');
//        $('#search-text').val("");
//    });
});



//***********************************************
//  Handlebars Stuff
//***********************************************

Number.prototype.formatDecimalLength = function(){
    if (this.toFixed(2) == this) {
        return this.toFixed(2);
    } else if (this.toFixed(3) == this){
        return this.toFixed(3);
    } else {
        return this.toFixed(4);
    }
};

Handlebars.registerHelper("formatDecimalLength", function(number) {
    return Number(number).formatDecimalLength();
});

Handlebars.registerHelper("formatDecimalLengthTwo", function(number) {
    return number.toFixed(2);
});

Number.prototype.formatMoney = function(c, d, t){
    var n = this,
        c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

Handlebars.registerHelper("formatMoney", function(number) {
    return number.formatMoney();
});

// Make comparison 'if' statements for handlebars, but call it 'compare' so we don't have to override 'if'
Handlebars.registerHelper('compare', function (lvalue, operator, rvalue, options) {

    var operators, result;

    if (arguments.length < 3) {
        throw new Error("Handlerbars Helper 'compare' needs 2 to 3 parameters");
    }

    if (options === undefined) {
        options = rvalue;
        rvalue = operator;
        operator = "===";
    }

    operators = {
        '==': function (l, r) { return l == r; },
        '===': function (l, r) { return l === r; },
        '!=': function (l, r) { return l != r; },
        '!==': function (l, r) { return l !== r; },
        '<': function (l, r) { return l < r; },
        '>': function (l, r) { return l > r; },
        '<=': function (l, r) { return l <= r; },
        '>=': function (l, r) { return l >= r; },
        'typeof': function (l, r) { return typeof l == r; }
    };

    if (!operators[operator]) {
        throw new Error("Handlerbars Helper 'compare' doesn't know the operator " + operator);
    }

    result = operators[operator](lvalue, rvalue);

    if (result) {
        return options.fn(this);
    } else {
        return options.inverse(this);
    }

});

// Make a way for handlebars to do math
Handlebars.registerHelper('math', function(lvalue, operator, rvalue, options) {
    lvalue = parseFloat(lvalue);
    rvalue = parseFloat(rvalue);

    if (arguments.length < 3) {
        throw new Error("Handlerbars Helper 'math' needs 2 to 3 parameters");
    }

    return {
        "+": lvalue + rvalue,
        "-": lvalue - rvalue,
        "*": lvalue * rvalue,
        "/": lvalue / rvalue,
        "%": lvalue % rvalue
    }[operator];
});

// Handlebars debugging
Handlebars.registerHelper("debug", function(optionalValue) {
    console.log("Current Context");
    console.log("====================");
    console.log(this);

    if (optionalValue) {
        console.log("Value");
        console.log("====================");
        console.log(optionalValue);
    }

});
