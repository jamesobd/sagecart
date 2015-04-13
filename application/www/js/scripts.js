$(function() {
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

    /*Quick Contact Form Validation
     *******************************************/
    $qcForm.validate();

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

    /*Small Header slide down on scroll
     *******************************************/
    if($(window).width() >= 500){
        $(window).on('scroll', function(){
            if($(window).scrollTop() > $headerOffsetTop ){
                $header.addClass('small-header');
            } else {
                $header.removeClass('small-header');
            }
            if($(window).scrollTop() > $headerStuck ){
                $header.addClass('stuck');
            } else {
                $header.removeClass('stuck');
            }
        });
    }


    /*Mobile Navigation
     *******************************************/
    //Mobile menu toggle
    $menuToggle.click(function(){
        $menu.toggleClass('expanded');
    });

    //Submenu Toggle
    $submenuToggle.click(function(e){
        $(this).toggleClass('open');
        $(this).parent().parent().find('.submenu').toggleClass('open');
        e.preventDefault();
    });

    /*Sticky Buttons
     *******************************************/
    //Scroll to Top Button
    $(window).scroll(function(){
        if ($(this).scrollTop() > 500) {
            $scrollTopBtn.parent().addClass('scrolled');
        } else {
            $scrollTopBtn.parent().removeClass('scrolled');
        }
    });
    $scrollTopBtn.click(function(){
        $('html, body').animate({scrollTop : 0}, {duration: 700, easing:"easeOutExpo"});
    });

    //Quick Contact Form
    $qcfBtn.click(function(){
        $(this).toggleClass('active');
        $(this).parent().find('.quick-contact').toggleClass('visible');
    });
    $('.page-content, .subscr-widget, footer, header').click(function(){
        $qcfBtn.removeClass('active');
        $('.quick-contact').removeClass('visible');
    });

    /*History page img switcher
     *******************************************/

    $('.panel-heading').click(function(){
        var hisroryID = $(this).data('img');
        $('.delivery-preview').removeClass('historyImgShow');
        $(hisroryID).addClass('historyImgShow');
    });

});