$.getParam = function (param) {
    return new URI().query(true)[param];
};

$.getSegment = function (segment) {
    return new URI().path().split('/')[segment];
};

$.setParam = function (param, value) {
    var uri = new URI().setSearch(param, value);
    app.navigate(uri.resource(), {trigger: true});
};

