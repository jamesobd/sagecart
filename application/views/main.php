<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Demo - SAGE Cart</title>
    <!--SEO Meta Tags-->
    <meta name="description" content="SAGE 100 E-Commerce Cart"/>
    <meta name="keywords"
          content="e-commerce, shop, SAGE 100, MAS 90, cart"/>
    <!--Mobile Specific Meta Tag-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <!--Favicon-->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <!--Master Slider Styles-->
    <link href="/masterslider/style/masterslider.css" rel="stylesheet" media="screen">
    <!--Styles-->
    <link href="/css/animate.css" rel="stylesheet" media="screen">
    <link href="/css/limo-theme.css" rel="stylesheet" media="screen">
    <link href="/css/colors/color-default.css" rel="stylesheet" media="screen">


    <!--Modernizr-->
    <script src="/js/vendor/modernizr.custom.js"></script>
    <!--Adding Media Queries Support for IE8-->
    <!--[if lt IE 9]>
    <script src="/js/vendor/respond.js"></script>
    <![endif]-->
</head>

<!--Body-->
<body>

<!--Login Modal-->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i>
                </button>
                <h2>Login or <a href="/register">Register</a></h2>

                <p class="large">Use social accounts</p>

                <div class="social-login">
                    <a class="facebook" href="#"><i class="fa fa-facebook-square"></i></a>
                    <a class="google" href="#"><i class="fa fa-google-plus-square"></i></a>
                    <a class="twitter" href="#"><i class="fa fa-twitter-square"></i></a>
                </div>
            </div>
            <div class="modal-body">
                <form class="login-form" action="#login">
                    <div class="form-group group">
                        <label for="log-email">Username</label>
                        <input type="text" class="form-control" name="username" id="log-email"
                               placeholder="Enter your Username" required>
                        <a class="help-link" href="#">Forgot username?</a>
                    </div>
                    <div class="form-group group">
                        <label for="log-password">Password</label>
                        <input type="text" class="form-control" name="password" id="log-password"
                               placeholder="Enter your password" required>
                        <a class="help-link" href="#">Forgot password?</a>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="remember"> Remember me</label>
                    </div>
                    <button class="btn btn-black" type="submit" style="position: relative;">Login</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!--Header-->
<header data-offset-top="500" data-stuck="600">
    <!--data-offset-top is when header converts to small variant and data-stuck when it becomes visible. Values in px represent position of scroll from top. Make sure there is at least 100px between those two values for smooth animation-->

    <!--Search Form-->
    <form class="search-form closed" method="get" role="form" autocomplete="off">
        <div class="container">
            <div class="close-search"><i class="icon-delete"></i></div>
            <div class="form-group">
                <label class="sr-only" for="search-hd">Search for product</label>
                <input type="text" class="form-control" name="search-hd" id="search-hd"
                       placeholder="Search for product">
                <button type="submit"><i class="icon-magnifier"></i></button>
            </div>
        </div>
    </form>

    <!--Mobile Menu Toggle-->
    <div class="menu-toggle"><i class="fa fa-list"></i></div>

    <div class="container">
        <a class="logo" href="/"><img src="/img/logo-default.png" alt="Limo"/></a>
    </div>

    <!--Main Menu-->
    <nav class="menu">
        <div class="container">

            <ul class="main">
                <li class="has-submenu"><a href="/"><span>H</span>ome<i class="fa fa-chevron-down"></i></a><!--Class "has-submenu" for proper highlighting and dropdown-->
                    <ul class="submenu">
                        <li><a href="/home-slideshow">Home - Slideshow</a></li>
                        <li><a href="/home-fullscreen">Home - Fullscreen Slider</a></li>
                        <li><a href="/home-showcase">Home - Product Showcase</a></li>
                        <li><a href="/home-categories">Home - Categories Slider</a></li>
                        <li><a href="/home-offers">Home - Special Offers</a></li>
                    </ul>
                </li>
                <li class="has-submenu"><a href="/shop-filters-left-3cols"><span>S</span>hop<i
                            class="fa fa-chevron-down"></i></a>
                    <ul class="submenu">
                        <li><a href="/shop-filters-left-3cols">Shop - Filters Left 3 Cols</a></li>
                        <li><a href="/shop-filters-left-2cols">Shop - Filters Left 2 Cols</a></li>
                        <li><a href="/shop-filters-right-3cols">Shop - Filters Right 3 Cols</a></li>
                        <li><a href="/shop-filters-right-2cols">Shop - Filters Right 2 Cols</a></li>
                        <li><a href="/shop-no-filters-4cols">Shop - No Filters 4 Cols</a></li>
                        <li><a href="/shop-no-filters-3cols">Shop - No Filters 3 Cols</a></li>
                        <li><a href="/products/1001-HON-H252">Shop - Single Item Vers 1</a></li>
                        <li><a href="/products/1001-HON-H252?ver=v2">Shop - Single Item Vers 2</a></li>
                        <li><a href="/shopping-cart">Shopping Cart</a></li>
                        <li><a href="/checkout">Checkout Page</a></li>
                        <li><a href="/wishlist">Wishlist</a></li>
                    </ul>
                </li>
                <li class="has-submenu"><a href="/blog-sidebar-right"><span>B</span>log<i
                            class="fa fa-chevron-down"></i></a>
                    <ul class="submenu">
                        <li><a href="/blog-sidebar-left">Blog - Sidebar Left</a></li>
                        <li><a href="/blog-sidebar-right">Blog - Sidebar Right</a></li>
                        <li><a href="/blog-single">Blog - Single Post</a></li>
                    </ul>
                </li>
                <li class="has-submenu"><a href="#"><span>P</span>ages<i class="fa fa-chevron-down"></i></a>
                    <ul class="submenu">
                        <li><a href="/register">Login / Registration</a></li>
                        <li><a href="/about">About Us</a></li>
                        <li><a href="/contacts">Contacts</a></li>
                        <li><a href="/support">Support Page</a></li>
                        <li><a href="/delivery">Delivery</a></li>
                        <li><a href="/history">History Page</a></li>
                        <li><a href="/tracking">Tracking Page</a></li>
                        <li><a href="/cs-page">Components &amp; Styles</a></li>
                    </ul>
                </li>
                <li class="hide-sm"><a href="/support"><span>S</span>upport</a></li>
            </ul>

        </div>

        <div class="catalog-block">
            <div class="container">
                <ul class="catalog" style="visibility: hidden;">
                    <li class="has-submenu"><a href="/shop-filters-left-3cols">Handbag<i
                                class="fa fa-chevron-down"></i></a>
                        <ul class="submenu">
                            <li><a href="#">Wristlet</a></li>
                            <li class="has-submenu"><a href="#">Backpack</a><!--Class "has-submenu" for adding carret and dropdown-->
                                <ul class="sub-submenu">
                                    <li><a href="#">KATA</a></li>
                                    <li><a href="#">Think Tank</a></li>
                                    <li><a href="#">Manfrotto</a></li>
                                    <li><a href="#">Lowepro</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Hat box</a></li>
                            <li class="has-submenu"><a href="#">Clutch</a>
                                <ul class="sub-submenu">
                                    <li><a href="#">Louis Vuitton</a></li>
                                    <li><a href="#">Chanel</a></li>
                                    <li><a href="#">Christian Dior</a></li>
                                    <li><a href="#">Gucci</a></li>
                                    <li><a href="#">Neri Karra</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Envelope</a></li>
                            <li class="offer">
                                <div class="col-1">
                                    <p class="p-style2">Use product images on the menu. It's easier to percept a visual
                                        content than a textual one. </p>
                                </div>
                                <div class="col-2">
                                    <img src="/img/offers/menu-drodown-offer.jpg" alt="Special Offer"/>
                                    <a class="btn btn-black" href="#"><span>$584</span>Special offer</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li><a href="/shop-filters-left-3cols">Wallet</a></li>
                    <li><a href="/shop-filters-left-3cols">Satchel</a></li>
                    <li><a href="/shop-filters-left-3cols">Clutch</a></li>
                    <li><a href="/shop-filters-left-3cols">Hobo bags</a></li>
                    <li><a href="/shop-filters-left-3cols">Shoulder Bag</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="toolbar-container">
        <div class="container">
            <!--Toolbar-->
            <div class="toolbar group">
                <a class="login-btn btn-outlined-invert" href="#" data-toggle="modal" data-target="#loginModal">
                    <i class="icon-profile"></i> <span><b>L</b>ogin</span></a>
                <a class="logout-btn btn-outlined-invert" href="#logout" style="display: none;">
                    <i class="icon-profile"></i> <span><b>L</b>ogout</span></a>

                <a class="btn-outlined-invert" href="/wishlist"><i class="icon-heart"></i>
                    <span><b>W</b>ishlist</span></a>

                <div class="cart-btn">
                    <a class="btn btn-outlined-invert" href="/shopping-cart"><i
                            class="icon-shopping-cart-content"></i><span>3</span><b>36 5654</b></a>

                    <!--Cart Dropdown-->
                    <div class="cart-dropdown">
                        <span></span><!--Small rectangle to overlap Cart button-->
                        <div class="body">
                            <table>
                                <tr>
                                    <th>Items</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                                <tr class="item">
                                    <td>
                                        <div class="delete"></div>
                                        <a href="#">Good Joo-Joo Surfb</a></td>
                                    <td><input type="text" value="1"></td>
                                    <td class="price">$89,005</td>
                                </tr>
                                <tr class="item">
                                    <td>
                                        <div class="delete"></div>
                                        <a href="#">Good Joo-Joo Item</a></td>
                                    <td><input type="text" value="2"></td>
                                    <td class="price">$4,300</td>
                                </tr>
                                <tr class="item">
                                    <td>
                                        <div class="delete"></div>
                                        <a href="#">Good Joo-Joo</a></td>
                                    <td><input type="text" value="5"></td>
                                    <td class="price">$84</td>
                                </tr>
                            </table>
                        </div>
                        <div class="footer group">
                            <div class="buttons">
                                <a class="btn btn-outlined-invert" href="/checkout"><i class="icon-download"></i>Checkout</a>
                                <a class="btn btn-outlined-invert" href="/shopping-cart"><i
                                        class="icon-shopping-cart-content"></i>To cart</a>
                            </div>
                            <div class="total">$93,389</div>
                        </div>
                    </div>
                    <!--Cart Dropdown Close-->
                </div>

                <button class="search-btn btn-outlined-invert"><i class="icon-magnifier"></i></button>
            </div>
            <!--Toolbar Close-->
        </div>
    </div>
</header>
<!--Header Close-->

<!--Page Content-->
<div id="content" class="page-content">
    <div style="height: 400px"></div>
</div>
<!--Page Content Close-->

<!--Sticky Buttons-->
<div class="sticky-btns">
    <form class="quick-contact" method="post" name="quick-contact" action="#contactus">
        <h3>Contact us</h3>

        <p class="text-muted">Send us a question or request more info on how to integrate eCommerce with SAGE 100.</p>

        <div class="form-group">
            <label for="qc-name">Full name</label>
            <input class="form-control input-sm" type="text" name="name" id="qc-name" placeholder="Enter full name"
                   required>
        </div>
        <div class="form-group">
            <label for="qc-email">Email</label>
            <input class="form-control input-sm" type="email" name="email" id="qc-email" placeholder="Enter email"
                   required>
        </div>
        <div class="form-group">
            <label for="qc-message">Your message</label>
            <textarea class="form-control input-sm" name="message" id="qc-message"
                      placeholder="Enter your message" required></textarea>
        </div>
        <!-- Validation Response -->
        <div class="response-holder"></div>
        <!-- Response End -->
        <button class="btn btn-black btn-sm btn-block" type="submit" style="position: relative;">Send</button>
    </form>
    <span id="qcf-btn"><i class="fa fa-envelope"></i></span>
    <span id="scrollTop-btn"><i class="fa fa-chevron-up"></i></span>
</div>
<!--Sticky Buttons Close-->

<!--Subscription Widget-->
<section class="subscr-widget gray-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-8 col-sm-8">
                <h2>Subscribe to our news</h2>

                <form class="subscr-form" role="form" autocomplete="off">
                    <div class="form-group">
                        <label class="sr-only" for="subscr-name">Enter name</label>
                        <input type="text" class="form-control" name="subscr-name" id="subscr-name"
                               placeholder="Enter name" required>
                        <button class="subscr-next"><i class="icon-arrow-right"></i></button>
                    </div>
                    <div class="form-group fff" style="display: none">
                        <label class="sr-only" for="subscr-email">Enter email</label>
                        <input type="email" class="form-control" name="subscr-email" id="subscr-email"
                               placeholder="Enter email" required>
                        <button type="submit" id="subscr-submit"><i class="icon-check"></i></button>
                    </div>
                </form>
                <p class="p-style2">Please fill the field before continuing</p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-1">
                <p class="p-style3">Get more followers. In case of high quality newsletters the customers return rate
                    can increase up to 20%! Have you already estimated your possible income? We took that into account
                    and created a decent subscription form. </p>
            </div>
        </div>
    </div>
</section>
<!--Subscription Widget Close-->

<!--Footer-->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="info">
                    <a class="logo" href="/"><img src="/img/logo-footer.png" alt="Limo"/></a>

                    <p>Describe the mission of your online store and the advantages a customer can get once he makes a
                        purchase. If you have something to tell let customers know about it.</p>

                    <div class="social">
                        <a href="#" target="_blank"><i class="fa fa-instagram"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-youtube-square"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-tumblr-square"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-vimeo-square"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-pinterest-square"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-facebook-square"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <h2>Latest news</h2>
                <ul class="list-unstyled">
                    <li>25 of May <a href="#">new arrivals in Spring</a></li>
                    <li>24 of April <a href="#">5 facts about clutches</a></li>
                    <li>25 of May <a href="#">new arrivals in Spring</a></li>
                    <li>24 of April <a href="#">5 facts about clutches</a></li>
                </ul>
            </div>
            <div class="contacts col-lg-3 col-md-3 col-sm-3">
                <h2>Contacts</h2>

                <h5>Online By Design</h5>

                <p class="p-style3">
                    Web: <a href="http://obdstudios.com">http://obdstudios.com</a><br/>
                    Phone: (208) 779-0123<br/>
                </p>

                <h5>Sage Data Exchange</h5>

                <p class="p-style3">
                    Web: <a href="http://sagedataexchange.com/">http://sagedataexchange.com/</a><br/>
                    Phone: (208) 779-0123<br/>
                </p>
            </div>
        </div>
        <div class="copyright">
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-7">
                    <p class="text-center">&copy; <?php echo date('Y') ?> Your Awesome Company. All Rights Reserved.<br>
                        Design implemented by <a href="http://obdstudios.com/" target="_blank">Online By Design</a> <span
                            style="margin:0 10px">-</span>
                        SAGE connection by <a href="http://sagedataexchange.com//" target="_blank">Sage Data Interchange</a>
                    </p>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5">
                    <div class="payment">
                        <img src="/img/payment/visa.png" alt="Visa"/>
                        <img src="/img/payment/paypal.png" alt="PayPal"/>
                        <img src="/img/payment/master.png" alt="Master Card"/>
                        <img src="/img/payment/discover.png" alt="Discover"/>
                        <img src="/img/payment/amazon.png" alt="Amazon"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--Footer Close-->

<!--Javascript (jQuery) Libraries and Plugins-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
    window.jQuery || document.write('<script src="/js/vendor/jquery-2.1.3.min.js"><\/script>');
</script>
<!--Theme Files-->
<script src="/js/vendor/jquery-ui-1.10.4.custom.min.js"></script>
<script src="/js/vendor/jquery.easing.min.js"></script>
<script src="/js/vendor/bootstrap.min.js"></script>
<script src="/js/vendor/smoothscroll.js"></script>
<script src="/js/vendor/jquery.validate.min.js"></script>
<script src="/js/vendor/icheck.min.js"></script>
<script src="/js/vendor/jquery.placeholder.js"></script>
<script src="/js/vendor/jquery.stellar.min.js"></script>
<script src="/js/vendor/jquery.touchSwipe.min.js"></script>
<script src="/js/vendor/jquery.shuffle.min.js"></script>
<script src="/js/vendor/lightGallery.min.js"></script>
<script src="/js/vendor/owl.carousel.min.js"></script>
<script src="/js/vendor/masterslider.min.js"></script>
<script src="/js/vendor/jquery.nouislider.min.js"></script>

<!--Added libraries-->
<script src="/js/vendor/lodash.min.js"></script>
<script src="/js/vendor/backbone-min.js"></script>
<script src="/js/vendor/handlebars.runtime-v3.0.0.js"></script>
<script src="/js/vendor/spin.min.js"></script>
<script src="/js/vendor/jquery.spin.js"></script>
<script src="/js/vendor/URI.min.js"></script>
<script src="/js/vendor/bootstrap-notify.min.js"></script>

<!--Custom theme scripts-->
<script src="/js/custom/handlebars.helpers.js"></script>
<script src="/js/custom/jquery.serializeObject.js"></script>
<script src="/js/custom/jquery.postJSON.js"></script>
<script src="/js/custom/jquery.uri.js"></script>
<script src="/js/scripts.js"></script>

<!--Templates-->
<script src="/js/custom/templates.js"></script>

<!-- Models -->
<script src="/js/models/user.js"></script>
<script src="/js/models/category.js"></script>
<script src="/js/models/product.js"></script>

<!-- Collections-->
<script src="/js/collections/categories.js"></script>
<script src="/js/collections/products.js"></script>

<!-- Views -->
<script src="/js/views/layouts/main-layout.js"></script>
<script src="/js/views/pages/auto-route-page.js"></script>
<script src="/js/views/pages/product-page.js"></script>
<script src="/js/views/lists/product-grid-list.js"></script>
<script src="/js/views/lists/gallery-grid-list.js"></script>
<script src="/js/views/items/product-grid-item.js"></script>
<script src="/js/views/pagination-view.js"></script>

<!-- Routes -->
<script src="/js/routes/main-route.js"></script>


<div class="modal-backdrop fade in" style="display: none"></div>
</body>
<!--Body Close-->
</html>