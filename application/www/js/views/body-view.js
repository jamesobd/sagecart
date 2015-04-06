App.Views.BodyView = Backbone.View.extend({
    el: 'body',

    events: {
        'click a[href^="/"]': 'navigateAnchor',
        'submit form[action^="/"]': 'navigateForm'
    },

    /**
     * Use History API on anchors by default since we are doing single page navigation
     */
    navigateAnchor: function(e) {
        e.preventDefault();
        app.navigate($(e.target).attr('href'), {trigger: true});
    },

    /**
     * Use History API on forms by default since we are doing single page navigation
     */
    navigateForm: function(e) {
        e.preventDefault();
        app.navigate($(e.target).attr('action') + '?' + $(e.target).serialize(), {trigger: true});
        this.$('form')[0].reset();
    }
});