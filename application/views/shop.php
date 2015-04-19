<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Store - Gulf Packaging</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/templates/fixedflex.css">
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>

<div class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div id="header" class="navbar-header row">
            <div id="cart-bar">
                <span id="cart">
                    <span id="cart-logo" class="glyphicon glyphicon-shopping-cart"></span>
                    <span id="cart-amount">$0.00</span>
                    <span id="cart-items">(0 items)</span>
                </span>
                <span class="divider">|</span>
                <span id="name">-</span>
                <span class="divider">|</span>
                <span id="logout"><a href="#logout">Logout</a></span>

            </div>
            <div id="search">
                <form action="/search">
                    <span id="search-logo" class="glyphicon glyphicon-search"></span>
                    <input type="text" id="search-text" name="q" placeholder="Search"/>
                    <input type="submit" id="search-button" value="Go"/>
                </form>
            </div>
        </div>
    </div>
</div>

<section class="container">
    <div class="row">
        <div class="col-md-2 home-link-div">
            <a id="home-link-fixedflex" href="/">
                <img src="/img/gulf-packaging-logo-2.png" alt="logo">
            </a>
        </div>
        <div class="col-md-10"></div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <nav id="main-nav"></nav>
        </div>
        <div class="col-sm-10">
            <div id="content"></div>
        </div>
    </div>
</section>

<footer id="footer">
    <div class="container text-center">
        <div id="the-local-national-people"><span id="the-local">The Local  </span><span id="national-people">National People</span>
        </div>
        <div id="footer-body">
            <div><p id="copyright">&copy;<?php echo date("Y"); ?> Gulf Packaging</p></div>
        </div>
    </div>
</footer>

<div class="modal-backdrop fade in" style="display: none"></div>

<?php echo $this->load->view('javascript_templates'); ?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>');
</script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
    window.jQuery || document.write('<script src="/js/vendor/jquery-2.1.3.min.js"><\/script>');
</script>

<script src="/js/custom/jquery.serializeObject.js"></script>
<script src="/js/custom/jquery.postJSON.js"></script>

<script src="/js/vendor/spin.min.js"></script>
<script src="/js/vendor/jquery.spin.js"></script>

<script src="/js/vendor/bootstrap.min.js"></script>

<script src="/js/vendor/URI.min.js"></script>
<script src="/js/custom/jquery.uri.js"></script>

<script src="/js/vendor/lodash.min.js"></script>
<script src="/js/custom/lodash.pagination.js"></script>

<script src="/js/vendor/backbone.js"></script>

<script src="/js/vendor/handlebars.runtime-v3.0.0.js"></script>
<script src="/js/custom/handlebars.helpers.js"></script>

<script>
    // Create App namespace for classes
    var App = App || {};
    App.Models = App.Models || {};
    App.Views = App.Views || {};
    App.Collections = App.Collections || {};
    App.Routes = App.Routes || {};
    App.Templates = App.Templates || {};

    // Create app namespace for instantiated classes
    var app = {};
</script>
<script src="/js/custom/partials.js"></script>
<script src="/js/custom/templates.js"></script>

<script src="/js/models/user.js"></script>
<script src="/js/models/category.js"></script>
<script src="/js/models/product.js"></script>
<script src="/js/collections/categories.js"></script>
<script src="/js/collections/products.js"></script>
<script src="/js/views/search-bar-view.js"></script>
<script src="/js/views/cart-bar-view.js"></script>
<script src="/js/views/nav-view.js"></script>
<script src="/js/views/content-view.js"></script>
<script src="/js/views/pages/default-page.js"></script>
<script src="/js/views/layouts/example-layout.js"></script>
<script src="/js/views/pages/product-list-page.js"></script>
<script src="/js/views/pages/cart-page-view.js"></script>
<script src="/js/views/partials/product-list-item-view.js"></script>
<script src="/js/views/partials/product-list-cart-item-view.js"></script>
<script src="/js/views/partials/product-list-view.js"></script>
<script src="/js/views/partials/pallet-info-view.js"></script>
<script src="/js/views/partials/product-limit-view.js"></script>
<script src="/js/routes/main-route.js"></script>

<div class="modal-backdrop in"></div>
</body>
</html>