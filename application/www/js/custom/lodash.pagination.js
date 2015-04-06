_.mixin({
    'paginate': function (collection, offset, limit) {
        var start = isNaN(Number(offset)) ? 0 : Number(offset);
        var end = isNaN(Number(limit)) ? undefined : start + Number(limit);
        return collection.slice(start, end);
    }
});