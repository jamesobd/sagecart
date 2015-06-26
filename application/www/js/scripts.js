App = {
    Models: {},
    Views: {},
    Collections: {},
    Routes: {}
};


$(function () {
    var $searchBtn = $('.search-btn');
    var $searchForm = $('.search-form');
    var $closeSearch = $('.close-search');
    var $subscrForm = $('.subscr-form');
    var $nextField = $('.subscr-next');
    var $qcForm = $('.quick-contact');
    var $contForm = $('.contact-form');
    var $checkoutForm = $('#checkout-form');
    var $header = $('header');
    var $headerOffsetTop = $header.data('offset-top');
    var $headerStuck = $header.data('stuck');
    var $menuToggle = $('.menu-toggle');
    var $menu = $('.menu');
    var $submenuToggle = $('.menu .has-submenu > a > i');
    var $scrollTopBtn = $('#scrollTop-btn');
    var $qcfBtn = $('#qcf-btn');

    /*Search Form Toggle
     *******************************************/
    $searchBtn.click(function () {
        $searchForm.removeClass('closed').addClass('open');
    });
    $closeSearch.click(function () {
        $searchForm.removeClass('open').addClass('closed');
    });
    $('.page-content, .subscr-widget, footer').click(function () {
        $searchForm.removeClass('open').addClass('closed');
    });

    /*Quick Contact Form Validation
     *******************************************/
    $qcForm.validate();
    $qcForm.on('submit', function (e) {
        e.preventDefault();
        if ($qcForm.valid()) {
            $.postJSON('/contactus', JSON.stringify($qcForm.serializeObject()), {
                success: function (data) {
                    $qcForm.removeClass('visible');
                    $qcForm.find(':input').prop("disabled", false);
                    $qcForm.find('button[type="submit"]').spin(false);
                    $qcForm[0].reset();
                    $.notify({message: data.message}, {
                        type: 'success',
                        placement: {
                            from: 'bottom',
                            align: 'right'
                        },
                        animate: {
                            enter: 'animated fadeInUp',
                            exit: 'animated fadeOutDown'
                        }
                    });
                },
                error: function (data) {
                    $qcForm.removeClass('visible');
                    $qcForm.find(':input').prop("disabled", false);
                    $qcForm.find('button[type="submit"]').spin(false);
                    $.notify({
                        message: data.responseJSON.message,
                        icon: 'fa fa-exclamation-triangle'
                    }, {
                        type: 'danger',
                        placement: {
                            from: 'bottom',
                            align: 'right'
                        },
                        animate: {
                            enter: 'animated fadeInUp',
                            exit: 'animated fadeOutDown'
                        }
                    });
                }
            });
            $qcForm.find(':input').prop("disabled", true);
            $qcForm.find('button[type="submit"]').spin({color: '#000', lines: 8, radius: 5});
        }
    });

    /*Contact Form Validation
     *******************************************/
    $contForm.validate();


    /*Checkout Form Validation
     *******************************************/
    $checkoutForm.validate({
        rules: {
            co_postcode: {
                required: true,
                number: true
            },
            co_phone: {
                required: true,
                number: true
            }
        }
    });

    /*Shopping Cart Dropdown
     *******************************************/
    //Deleting Items
    $(document).on('click', '.cart-dropdown .delete', function () {
        var $target = $(this).parent().parent();
        var $positions = $('.cart-dropdown .item');
        var $positionQty = parseInt($('.cart-btn a span').text());
        $target.hide(300, function () {
            $.when($target.remove()).then(function () {
                $positionQty = $positionQty - 1;
                $('.cart-btn a span').text($positionQty);
                if ($positions.length === 1) {
                    $('.cart-dropdown .body').html('<h3>Cart is empty!</h3>');
                }
            });
        });
    });

    /*Small Header slide down on scroll
     *******************************************/
    if ($(window).width() >= 500) {
        $(window).on('scroll', function () {
            if ($(window).scrollTop() > $headerOffsetTop) {
                $header.addClass('small-header');
            } else {
                $header.removeClass('small-header');
            }
            if ($(window).scrollTop() > $headerStuck) {
                $header.addClass('stuck');
            } else {
                $header.removeClass('stuck');
            }
        });
    }

    /*Mobile Navigation
     *******************************************/
    //Mobile menu toggle
    $menuToggle.click(function () {
        $menu.toggleClass('expanded');
    });

    //Submenu Toggle
    $submenuToggle.click(function (e) {
        $(this).toggleClass('open');
        $(this).parent().parent().find('.submenu').toggleClass('open');
        e.preventDefault();
    });

    /*Subscription Form Widget
     *******************************************/
    $subscrForm.validate();
    $nextField.click(function (e) {
        var $target = $(this).parent();
        if ($subscrForm.valid() === true) {
            $target.hide('drop', 300, function () {
                $target.next().show('drop', 300);
            });
        }
        e.preventDefault();
    });

    /*Sticky Buttons
     *******************************************/
    //Scroll to Top Button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 500) {
            $scrollTopBtn.parent().addClass('scrolled');
        } else {
            $scrollTopBtn.parent().removeClass('scrolled');
        }
    });
    $scrollTopBtn.click(function () {
        $('html, body').animate({scrollTop: 0}, {duration: 700, easing: "easeOutExpo"});
    });

    //Quick Contact Form
    $qcfBtn.click(function () {
        $(this).toggleClass('active');
        $(this).parent().find('.quick-contact').toggleClass('visible');
    });
    $('.page-content, .subscr-widget, footer, header').click(function () {
        $qcfBtn.removeClass('active');
        $('.quick-contact').removeClass('visible');
    });

    /*History page img switcher
     *******************************************/

    $('.panel-heading').click(function () {
        var hisroryID = $(this).data('img');
        $('.delivery-preview').removeClass('historyImgShow');
        $(hisroryID).addClass('historyImgShow');
    });

});