$.postJSON = function (url, data, options) {
    options = _.defaults(options, {
        method: 'POST',
        data: data,
        cache: false,
        contentType: 'application/json; charset=utf-8',
        dataType: 'json'
    });
    return $.ajax(url, options);
};