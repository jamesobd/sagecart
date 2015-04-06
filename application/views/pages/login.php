<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Store - Gulf Packaging</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/templates/flex.css">
    <link rel="stylesheet" href="/css/main.css">

    <script src="/js/vendor/modernizr-2.6.2.min.js"></script>
    <script src="/js/vendor/math.min.js"></script>
</head>
<body>

<div class="navbar navbar-default navbar-static-top">
</div>

<section class="container">
    <div class="row">
        <div class="col-md-2 home-link-div">
            <a id="home-link-home" href="/">
                <img src="../img/gulf-packaging-logo-2.png" alt="logo">
            </a>
        </div>
        <div class="col-md-10"></div>
    </div>
    <!--            <script>$('.modal-backdrop').css({"display":"block"});</script>-->
    <div id="content" class="row">
        <div class="content">
            <form role="form" name='login-form' method="post" action="/">
                <div class="alert alert-danger" style="display:none;"></div>
                <div class="form-group">
                    <input type="text" name="email" id="email" placeholder="Email" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" placeholder="Password" class="form-control"/>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default">
                        Log In
                    </button>
                </div>
            </form>
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

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
    window.jQuery || document.write('<script src="/js/vendor/jquery-2.1.3.min.js"><\/script>');
</script>
<script src="/js/custom/jquery.serializeObject.js"></script>
<script src="/js/custom/jquery.postJSON.js"></script>

<script src="/js/vendor/lodash.min.js"></script>
<script src="/js/vendor/backbone-min.js"></script>

<script>
    var App = {
        Models: {},
        Views: {},
        Collections: {},
        Routes: {}
    };
</script>
<script src="/js/models/contact.js"></script>
<script src="/js/views/partials/contact-form-view.js"></script>
<script src="/js/routes/app-login.js"></script>

</body>
</html>