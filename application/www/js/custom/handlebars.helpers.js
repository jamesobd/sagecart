Handlebars.registerHelper("debug", function (optionalValue) {
    console.log("Current Context", this);

    if (optionalValue) {
        console.log("Value", optionalValue);
    }
});

Handlebars.registerHelper("numberToFixed", function (number, places) {
    return Number(number).toFixed(places);
});

Handlebars.registerHelper("arrayContains", function (array, value) {
    return array.indexOf(value) != -1;
})

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

Handlebars.registerHelper('select', function (value, options) {
    return $('<select />').html(options.fn(this)).find('[value="' + value + '"]').attr({'selected': 'selected'}).end().html();
});