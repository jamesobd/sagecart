(function() {
  var template = Handlebars.template, templates = App.Templates = App.Templates || {};
templates['cart-footer'] = template({"1":function(depth0,helpers,partials,data) {
    return "$"
    + this.escapeExpression((helpers.numberToFixed || (depth0 && depth0.numberToFixed) || helpers.helperMissing).call(depth0,(depth0 != null ? depth0.FreightAmt : depth0),2,{"name":"numberToFixed","hash":{},"data":data}));
},"3":function(depth0,helpers,partials,data) {
    return "<span>See freight info</span>";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "<div class=\"row spacing-p\">\r\n    <div id=\"freight-info-desc\" class=\"col-sm-8\">\r\n        <strong>"
    + alias3(((helper = (helper = helpers.UDF_FREIGHT_INFO || (depth0 != null ? depth0.UDF_FREIGHT_INFO : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"UDF_FREIGHT_INFO","hash":{},"data":data}) : helper)))
    + "</strong>\r\n    </div>\r\n    <div class=\"col-sm-4\">\r\n        <div class=\"pallet-totals form-horizontal\">\r\n            <div class=\"form-group form-group-sm\">\r\n                <label class=\"col-sm-6 control-label\">Total Pallets:</label>\r\n\r\n                <p class=\"col-sm-6 form-control-static\">\r\n                    <strong id=\"cart-total\">"
    + alias3((helpers.numberToFixed || (depth0 && depth0.numberToFixed) || alias1).call(depth0,(depth0 != null ? depth0.totalPallets : depth0),2,{"name":"numberToFixed","hash":{},"data":data}))
    + "</strong>\r\n                </p>\r\n            </div>\r\n            <div class=\"form-group form-group-sm\">\r\n                <label class=\"col-sm-6 control-label\">Subtotal:</label>\r\n\r\n                <p class=\"col-sm-6 form-control-static\">\r\n                    <strong id=\"cart-total\">$"
    + alias3((helpers.numberToFixed || (depth0 && depth0.numberToFixed) || alias1).call(depth0,(depth0 != null ? depth0.subtotal : depth0),2,{"name":"numberToFixed","hash":{},"data":data}))
    + "</strong>\r\n                </p>\r\n            </div>\r\n            <div class=\"form-group form-group-sm\">\r\n                <label class=\"col-sm-6 control-label\">Freight:</label>\r\n\r\n                <p class=\"col-sm-6 form-control-static\">\r\n                    <strong id=\"cart-total\">"
    + ((stack1 = helpers['if'].call(depth0,(depth0 != null ? depth0.ShipToAddress : depth0),{"name":"if","hash":{},"fn":this.program(1, data, 0),"inverse":this.program(3, data, 0),"data":data})) != null ? stack1 : "")
    + "\r\n                    </strong>\r\n                </p>\r\n            </div>\r\n            <div class=\"form-group form-group-sm\">\r\n                <label class=\"col-sm-6 control-label\">Tax:</label>\r\n\r\n                <p class=\"col-sm-6 form-control-static\">\r\n                    <strong id=\"cart-total\">$"
    + alias3((helpers.numberToFixed || (depth0 && depth0.numberToFixed) || alias1).call(depth0,(depth0 != null ? depth0.SalesTaxAmt : depth0),2,{"name":"numberToFixed","hash":{},"data":data}))
    + "</strong>\r\n                </p>\r\n            </div>\r\n            <div class=\"form-group form-group-sm\">\r\n                <label class=\"col-sm-6 control-label\">Total:</label>\r\n\r\n                <p class=\"col-sm-6 form-control-static\">\r\n                    <strong id=\"cart-total\">$"
    + alias3((helpers.numberToFixed || (depth0 && depth0.numberToFixed) || alias1).call(depth0,(depth0 != null ? depth0.total : depth0),2,{"name":"numberToFixed","hash":{},"data":data}))
    + "</strong>\r\n                </p>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</div>\r\n\r\n<div class=\"row spacing-p\">\r\n    <div class=\"col-sm-7\"></div>\r\n    <div class=\"col-sm-5\">\r\n        <textarea id=\"shipping-comments\" name=\"ShippingComments\" class=\"form-control\" rows=\"3\"\r\n                  placeholder=\"Order Comments\">"
    + alias3(((helper = (helper = helpers.Comment || (depth0 != null ? depth0.Comment : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"Comment","hash":{},"data":data}) : helper)))
    + "</textarea>\r\n\r\n        <div id=\"comments-chars\" class=\"text-right\">0 of 2048</div>\r\n    </div>\r\n</div>\r\n\r\n<div class=\"row spacing-p\">\r\n    <div class=\"col-sm-12\">\r\n        <div id=\"cart-footer-checkout\" class=\"clearfix\">\r\n            <div class=\"form-inline pull-right\">\r\n                <button id=\"cart-checkout\" class=\"btn btn-primary btn-lg\" data-loading-text=\"Loading...\">Review Order<span\r\n                        class=\"glyphicon glyphicon-chevron-right\" aria-hidden=\"true\"></span></button>\r\n            </div>\r\n        </div>\r\n        <div id=\"cart-footer-submit\" class=\"clearfix\" style=\"display: none\">\r\n            <div class=\"form-inline pull-right\">\r\n                <h3 class=\"text-right text-danger\">Please confirm your order.</h3>\r\n\r\n                <div class=\"form-group text-right\">\r\n                    <div><strong>For questions or contact inquiries</strong></div>\r\n                    <div>call 1-877-505-8909</div>\r\n                    <div>or send us <a href=\"/contactus\">an email.</a></div>\r\n                </div>\r\n                <button id=\"cart-cancel-submit\" class=\"btn btn-default btn-lg\">Cancel</button>\r\n                <button id=\"cart-submit\" class=\"btn btn-primary btn-lg\">Submit Order</button>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</div>";
},"useData":true});
templates['content-header'] = template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var helper;

  return "<div class=\"row\">\r\n    <div class=\"col-sm-12\">\r\n        <h1>"
    + this.escapeExpression(((helper = (helper = helpers.header || (depth0 != null ? depth0.header : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"header","hash":{},"data":data}) : helper)))
    + "</h1>\r\n    </div>\r\n</div>";
},"useData":true});
templates['home'] = template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    return "<div id=\"product-list-description\" class=\"product-list-description\">\r\n    <h1>Welcome to Gulf Packaging Online Ordering</h1>\r\n    <p>Click on a category to the left or use the search above to find your products.</p>\r\n</div>";
},"useData":true});
templates['login-dialog'] = template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    return "<!--Login Modal-->\r\n<div class=\"modal fade\" id=\"loginModal\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">\r\n    <div class=\"modal-dialog\">\r\n        <div class=\"modal-content\">\r\n            <div class=\"modal-header\">\r\n                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\"><i class=\"fa fa-times\"></i></button>\r\n                <h2>Login or <a href=\"/register.html\">Register</a></h2>\r\n                <p class=\"large\">Use social accounts</p>\r\n                <div class=\"social-login\">\r\n                    <a class=\"facebook\" href=\"#\"><i class=\"fa fa-facebook-square\"></i></a>\r\n                    <a class=\"google\" href=\"#\"><i class=\"fa fa-google-plus-square\"></i></a>\r\n                    <a class=\"twitter\" href=\"#\"><i class=\"fa fa-twitter-square\"></i></a>\r\n                </div>\r\n            </div>\r\n            <div class=\"modal-body\">\r\n                <form class=\"login-form\">\r\n                    <div class=\"form-group group\">\r\n                        <label for=\"log-email\">Email</label>\r\n                        <input type=\"email\" class=\"form-control\" name=\"log-email\" id=\"log-email\" placeholder=\"Enter your email\" required>\r\n                        <a class=\"help-link\" href=\"#\">Forgot email?</a>\r\n                    </div>\r\n                    <div class=\"form-group group\">\r\n                        <label for=\"log-password\">Password</label>\r\n                        <input type=\"text\" class=\"form-control\" name=\"log-password\" id=\"log-password\" placeholder=\"Enter your password\" required>\r\n                        <a class=\"help-link\" href=\"#\">Forgot password?</a>\r\n                    </div>\r\n                    <div class=\"checkbox\">\r\n                        <label><input type=\"checkbox\" name=\"remember\"> Remember me</label>\r\n                    </div>\r\n                    <input class=\"btn btn-black\" type=\"submit\" value=\"Login\">\r\n                </form>\r\n            </div>\r\n        </div><!-- /.modal-content -->\r\n    </div><!-- /.modal-dialog -->\r\n</div><!-- /.modal -->\r\n";
},"useData":true});
templates['login-page'] = template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    return "<div class=\"row\">\r\n    <!--Login-->\r\n    <div class=\"col-sm-offset-3 col-sm-5\">\r\n        <h2>Login</h2>\r\n        <form method=\"post\" class=\"login-form\">\r\n            <div class=\"form-group group\">\r\n                <label for=\"log-email2\">Email</label>\r\n                <input type=\"email\" class=\"form-control\" name=\"log-email2\" id=\"log-email2\"\r\n                       placeholder=\"Enter your email\" required>\r\n                <a class=\"help-link\" href=\"#\">Forgot email?</a>\r\n            </div>\r\n            <div class=\"form-group group\">\r\n                <label for=\"log-password2\">Password</label>\r\n                <input type=\"text\" class=\"form-control\" name=\"log-password2\" id=\"log-password2\"\r\n                       placeholder=\"Enter your password\" required>\r\n                <a class=\"help-link\" href=\"#\">Forgot password?</a>\r\n            </div>\r\n            <div class=\"checkbox\">\r\n                <label><input type=\"checkbox\" name=\"remember\"> Remember me</label>\r\n            </div>\r\n            <input class=\"btn btn-black\" type=\"submit\" value=\"Login\">\r\n        </form>\r\n    </div>\r\n</div>";
},"useData":true});
templates['nav'] = template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    return "<div class=\"container\">\r\n\r\n    <ul class=\"main\">\r\n        <li class=\"has-submenu\"><a href=\"\"><span>H</span>ome<i class=\"fa fa-chevron-down\"></i></a><!--Class \"has-submenu\" for proper highlighting and dropdown-->\r\n            <ul class=\"submenu\">\r\n                <li><a href=\"/\">Home - Signin</a></li>\r\n                <li><a href=\"/index.html\">Home - Slideshow</a></li>\r\n                <li><a href=\"/home-fullscreen.html\">Home - Fullscreen Slider</a></li>\r\n                <li><a href=\"/home-showcase.html\">Home - Product Showcase</a></li>\r\n                <li><a href=\"/home-categories.html\">Home - Categories Slider</a></li>\r\n                <li><a href=\"/home-offers.html\">Home - Special Offers</a></li>\r\n            </ul>\r\n        </li>\r\n        <li class=\"has-submenu\"><a href=\"/shop-filters-left-3cols.html\"><span>S</span>hop<i\r\n                class=\"fa fa-chevron-down\"></i></a>\r\n            <ul class=\"submenu\">\r\n                <li><a href=\"/shop-filters-left-3cols.html\">Shop - Filters Left 3 Cols</a></li>\r\n                <li><a href=\"/shop-filters-left-2cols.html\">Shop - Filters Left 2 Cols</a></li>\r\n                <li><a href=\"/shop-filters-right-3cols.html\">Shop - Filters Right 3 Cols</a></li>\r\n                <li><a href=\"/shop-filters-right-2cols.html\">Shop - Filters Right 2 Cols</a></li>\r\n                <li><a href=\"/shop-no-filters-4cols.html\">Shop - No Filters 4 Cols</a></li>\r\n                <li><a href=\"/shop-no-filters-3cols.html\">Shop - No Filters 3 Cols</a></li>\r\n                <li><a href=\"/shop-single-item-v1.html\">Shop - Single Item Vers 1</a></li>\r\n                <li><a href=\"/shop-single-item-v2.html\">Shop - Single Item Vers 2</a></li>\r\n                <li><a href=\"/shopping-cart.html\">Shopping Cart</a></li>\r\n                <li><a href=\"/checkout.html\">Checkout Page</a></li>\r\n                <li><a href=\"/wishlist.html\">Wishlist</a></li>\r\n            </ul>\r\n        </li>\r\n        <li class=\"has-submenu\"><a href=\"/blog-sidebar-right.html\"><span>B</span>log<i\r\n                class=\"fa fa-chevron-down\"></i></a>\r\n            <ul class=\"submenu\">\r\n                <li><a href=\"/blog-sidebar-left.html\">Blog - Sidebar Left</a></li>\r\n                <li><a href=\"/blog-sidebar-right.html\">Blog - Sidebar Right</a></li>\r\n                <li><a href=\"/blog-single.html\">Blog - Single Post</a></li>\r\n            </ul>\r\n        </li>\r\n        <li class=\"has-submenu\"><a href=\"#\"><span>P</span>ages<i class=\"fa fa-chevron-down\"></i></a>\r\n            <ul class=\"submenu\">\r\n                <li><a href=\"/register.html\">Login / Registration</a></li>\r\n                <li><a href=\"/about.html\">About Us</a></li>\r\n                <li><a href=\"/contacts.html\">Contacts</a></li>\r\n                <li><a href=\"/coming-soon.html\">Coming Soon</a></li>\r\n                <li><a href=\"/404.html\">404 Page</a></li>\r\n                <li><a href=\"/support.html\">Support Page</a></li>\r\n                <li><a href=\"/delivery.html\">Delivery</a></li>\r\n                <li><a href=\"/history.html\">History Page</a></li>\r\n                <li><a href=\"/tracking.html\">Tracking Page</a></li>\r\n                <li><a href=\"/cs-page.html\">Components &amp; Styles</a></li>\r\n            </ul>\r\n        </li>\r\n        <li class=\"hide-sm\"><a href=\"/support.html\"><span>S</span>upport</a></li>\r\n    </ul>\r\n\r\n</div>\r\n\r\n<div class=\"catalog-block\">\r\n    <div class=\"container\">\r\n        <ul class=\"catalog\">\r\n            <li class=\"has-submenu\"><a href=\"/shop-filters-left-3cols.html\">Handbag<i\r\n                    class=\"fa fa-chevron-down\"></i></a>\r\n                <ul class=\"submenu\">\r\n                    <li><a href=\"#\">Wristlet</a></li>\r\n                    <li class=\"has-submenu\"><a href=\"#\">Backpack</a><!--Class \"has-submenu\" for adding carret and dropdown-->\r\n                        <ul class=\"sub-submenu\">\r\n                            <li><a href=\"#\">KATA</a></li>\r\n                            <li><a href=\"#\">Think Tank</a></li>\r\n                            <li><a href=\"#\">Manfrotto</a></li>\r\n                            <li><a href=\"#\">Lowepro</a></li>\r\n                        </ul>\r\n                    </li>\r\n                    <li><a href=\"#\">Hat box</a></li>\r\n                    <li class=\"has-submenu\"><a href=\"#\">Clutch</a>\r\n                        <ul class=\"sub-submenu\">\r\n                            <li><a href=\"#\">Louis Vuitton</a></li>\r\n                            <li><a href=\"#\">Chanel</a></li>\r\n                            <li><a href=\"#\">Christian Dior</a></li>\r\n                            <li><a href=\"#\">Gucci</a></li>\r\n                            <li><a href=\"#\">Neri Karra</a></li>\r\n                        </ul>\r\n                    </li>\r\n                    <li><a href=\"#\">Envelope</a></li>\r\n                    <li class=\"offer\">\r\n                        <div class=\"col-1\">\r\n                            <p class=\"p-style2\">Use product images on the menu. It's easier to percept a visual\r\n                                content than a textual one. </p>\r\n                        </div>\r\n                        <div class=\"col-2\">\r\n                            <img src=\"/img/offers/menu-drodown-offer.jpg\" alt=\"Special Offer\"/>\r\n                            <a class=\"btn btn-black\" href=\"#\"><span>584$</span>Special offer</a>\r\n                        </div>\r\n                    </li>\r\n                </ul>\r\n            </li>\r\n            <li><a href=\"/shop-filters-left-3cols.html\">Wallet</a></li>\r\n            <li><a href=\"/shop-filters-left-3cols.html\">Satchel</a></li>\r\n            <li><a href=\"/shop-filters-left-3cols.html\">Clutch</a></li>\r\n            <li><a href=\"/shop-filters-left-3cols.html\">Hobo bags</a></li>\r\n            <li><a href=\"/shop-filters-left-3cols.html\">Shoulder Bag</a></li>\r\n        </ul>\r\n    </div>\r\n</div>\r\n";
},"useData":true});
templates['pallet-info'] = template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var helper;

  return "<div class=\"col-sm-offset-8 col-sm-4\">\r\n    <div class=\"pallet-totals form-horizontal\">\r\n        <div class=\"form-group\">\r\n            <div class=\"col-sm-9 control-label\">Pallets In Cart:</div>\r\n            <p class=\"pallets-in-cart col-sm-3 form-control-static\">"
    + this.escapeExpression(((helper = (helper = helpers.palletsInCart || (depth0 != null ? depth0.palletsInCart : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"palletsInCart","hash":{},"data":data}) : helper)))
    + "</p>\r\n        </div>\r\n\r\n        <div class=\"form-group\">\r\n            <div class=\"col-sm-9 control-label\">Pallets To Be Added:</div>\r\n            <p class=\"pallets-to-add col-sm-3 form-control-static\">0.00</p>\r\n        </div>\r\n\r\n        <div class=\"form-group\">\r\n            <div class=\"col-sm-9 control-label\">New Total Pallets:</div>\r\n            <p class=\"new-total-pallets col-sm-3 form-control-static\">0.00</p>\r\n        </div>\r\n\r\n        <div class=\"form-group\">\r\n        <div class=\"col-sm-12 control-label text-right\">\r\n            <button class=\"add-all-to-cart btn btn-default\"><i class=\"icon-shopping-cart\"></i> Add All Items to Cart\r\n            </button>\r\n        </div>\r\n            </div>\r\n    </div>\r\n</div>";
},"useData":true});
templates['product-limit'] = template({"1":function(depth0,helpers,partials,data) {
    return "            <option value=\"10\">10</option>\r\n            <option value=\"25\">25</option>\r\n            <option value=\"50\">50</option>\r\n            <option value=\"100\">100</option>\r\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1;

  return "<div id=\"product-limit\" style=\"display: none;\">\r\n    <span id=\"show-page\" class=\"rightAlign\">\r\n        <label for=\"show-page-option\">Show:</label>\r\n        <select id=\"show-page-option\" class=\"form-control\">showPageOption\r\n"
    + ((stack1 = (helpers.select || (depth0 && depth0.select) || helpers.helperMissing).call(depth0,(depth0 != null ? depth0.value : depth0),{"name":"select","hash":{},"fn":this.program(1, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "        </select>\r\n    </span>\r\n</div>";
},"useData":true});
templates['product-list-cart-item'] = template({"1":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "        <div class=\"image col-sm-2\">\r\n            <img src=\"http://images.gulfpackaging.com/img/TST/"
    + alias3(((helper = (helper = helpers.ImageFile || (depth0 != null ? depth0.ImageFile : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"ImageFile","hash":{},"data":data}) : helper)))
    + "\"\r\n                 class=\"img-responsive img-thumbnail\"/>\r\n        </div>\r\n\r\n        <div class=\"details col-sm-7\">\r\n            <h4>"
    + ((stack1 = helpers['if'].call(depth0,(depth0 != null ? depth0.ItemName : depth0),{"name":"if","hash":{},"fn":this.program(2, data, 0),"inverse":this.program(4, data, 0),"data":data})) != null ? stack1 : "")
    + "</h4>\r\n\r\n            <p>"
    + alias3(((helper = (helper = helpers.ItemLongDesc || (depth0 != null ? depth0.ItemLongDesc : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"ItemLongDesc","hash":{},"data":data}) : helper)))
    + "</p>\r\n"
    + ((stack1 = helpers['if'].call(depth0,(depth0 != null ? depth0.OrderIncrement : depth0),{"name":"if","hash":{},"fn":this.program(6, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "            <p>Item #: "
    + alias3(((helper = (helper = helpers.ItemCode || (depth0 != null ? depth0.ItemCode : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"ItemCode","hash":{},"data":data}) : helper)))
    + "</p>\r\n        </div>\r\n";
},"2":function(depth0,helpers,partials,data) {
    var helper;

  return this.escapeExpression(((helper = (helper = helpers.ItemName || (depth0 != null ? depth0.ItemName : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"ItemName","hash":{},"data":data}) : helper)));
},"4":function(depth0,helpers,partials,data) {
    var helper;

  return this.escapeExpression(((helper = (helper = helpers.ItemCodeDesc || (depth0 != null ? depth0.ItemCodeDesc : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"ItemCodeDesc","hash":{},"data":data}) : helper)));
},"6":function(depth0,helpers,partials,data) {
    var helper;

  return "                <p>Item must be ordered in multiples of "
    + this.escapeExpression(((helper = (helper = helpers.OrderIncrement || (depth0 != null ? depth0.OrderIncrement : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"OrderIncrement","hash":{},"data":data}) : helper)))
    + "</p>\r\n";
},"8":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "        <div class=\"details col-sm-9\">\r\n            <h4>"
    + ((stack1 = helpers['if'].call(depth0,(depth0 != null ? depth0.ItemName : depth0),{"name":"if","hash":{},"fn":this.program(2, data, 0),"inverse":this.program(4, data, 0),"data":data})) != null ? stack1 : "")
    + "</h4>\r\n\r\n            <p>"
    + alias3(((helper = (helper = helpers.ItemLongDesc || (depth0 != null ? depth0.ItemLongDesc : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"ItemLongDesc","hash":{},"data":data}) : helper)))
    + "</p>\r\n"
    + ((stack1 = helpers['if'].call(depth0,(depth0 != null ? depth0.OrderIncrement : depth0),{"name":"if","hash":{},"fn":this.program(6, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "            <p>Item #: "
    + alias3(((helper = (helper = helpers.ItemCode || (depth0 != null ? depth0.ItemCode : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"ItemCode","hash":{},"data":data}) : helper)))
    + "</p>\r\n        </div>\r\n";
},"10":function(depth0,helpers,partials,data) {
    var helper;

  return "                <div class=\"form-group form-group-sm\">\r\n                    <label class=\"col-sm-6 control-label\">Pallets:</label>\r\n\r\n                    <p class=\"pallets col-sm-6 form-control-static\" style=\"text-align: left\">"
    + this.escapeExpression(((helper = (helper = helpers._Pallets || (depth0 != null ? depth0._Pallets : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"_Pallets","hash":{},"data":data}) : helper)))
    + "</p>\r\n                </div>\r\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2=this.escapeExpression, alias3="function";

  return "<div class=\"row\">\r\n"
    + ((stack1 = helpers['if'].call(depth0,(depth0 != null ? depth0.ImageFile : depth0),{"name":"if","hash":{},"fn":this.program(1, data, 0),"inverse":this.program(8, data, 0),"data":data})) != null ? stack1 : "")
    + "\r\n    <div class=\"item-pricing col-sm-3\">\r\n        <div class=\"form-horizontal\">\r\n            <div class=\"form-group form-group-sm\">\r\n                <label class=\"col-sm-6 control-label\">Price:</label>\r\n\r\n                <p class=\"price col-sm-6 form-control-static\">$"
    + alias2((helpers.numberToFixed || (depth0 && depth0.numberToFixed) || alias1).call(depth0,(depth0 != null ? depth0.CustomerPrice : depth0),2,{"name":"numberToFixed","hash":{},"data":data}))
    + "\r\n                    / "
    + alias2(((helper = (helper = helpers.SalesUnitOfMeasure || (depth0 != null ? depth0.SalesUnitOfMeasure : depth0)) != null ? helper : alias1),(typeof helper === alias3 ? helper.call(depth0,{"name":"SalesUnitOfMeasure","hash":{},"data":data}) : helper)))
    + "</p>\r\n            </div>\r\n\r\n            <div class=\"form-group form-group-sm\">\r\n                <label for=\"Quantity\" class=\"col-sm-6 control-label\">Qty:</label>\r\n\r\n                <p class=\"quantity col-sm-6 form-control-static\"\r\n                   style=\"text-align: left; display: none;\">"
    + alias2(((helper = (helper = helpers._Quantity || (depth0 != null ? depth0._Quantity : depth0)) != null ? helper : alias1),(typeof helper === alias3 ? helper.call(depth0,{"name":"_Quantity","hash":{},"data":data}) : helper)))
    + "</p>\r\n\r\n                <div class=\"col-sm-6\">\r\n                    <input type=\"text\" class=\"quantity form-control input-sm\" name=\"quantity\" value=\""
    + alias2(((helper = (helper = helpers._Quantity || (depth0 != null ? depth0._Quantity : depth0)) != null ? helper : alias1),(typeof helper === alias3 ? helper.call(depth0,{"name":"_Quantity","hash":{},"data":data}) : helper)))
    + "\">\r\n                </div>\r\n            </div>\r\n\r\n"
    + ((stack1 = (helpers.compare || (depth0 && depth0.compare) || alias1).call(depth0,(depth0 != null ? depth0.UDF_IT_PER_PALLET : depth0),">",0,{"name":"compare","hash":{},"fn":this.program(10, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "\r\n            <div class=\"form-group form-group-sm\">\r\n                <label class=\"col-sm-6 control-label\">Item Total:</label>\r\n\r\n                <p class=\"total col-sm-6 form-control-static\" style=\"text-align: left\">$"
    + alias2((helpers.numberToFixed || (depth0 && depth0.numberToFixed) || alias1).call(depth0,(depth0 != null ? depth0._Total : depth0),2,{"name":"numberToFixed","hash":{},"data":data}))
    + "</p>\r\n            </div>\r\n\r\n            <div class=\"col-sm-12 control-label text-right\">\r\n                <a href=\"javascript:\" class=\"update form-control-static\" style=\"display: none;\">Update</a>\r\n                <a href=\"javascript:\" class=\"remove form-control-static\">Remove</a>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</div>\r\n";
},"useData":true});
templates['product-list-item'] = template({"1":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "        <div class=\"image col-sm-2\">\r\n            <img src=\"http://images.gulfpackaging.com/img/TST/"
    + alias3(((helper = (helper = helpers.ImageFile || (depth0 != null ? depth0.ImageFile : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"ImageFile","hash":{},"data":data}) : helper)))
    + "\"\r\n                 class=\"img-responsive img-thumbnail\"/>\r\n        </div>\r\n\r\n        <div class=\"details col-sm-7\">\r\n            <h4>"
    + ((stack1 = helpers['if'].call(depth0,(depth0 != null ? depth0.ItemName : depth0),{"name":"if","hash":{},"fn":this.program(2, data, 0),"inverse":this.program(4, data, 0),"data":data})) != null ? stack1 : "")
    + "</h4>\r\n\r\n            <p>"
    + alias3(((helper = (helper = helpers.ItemLongDesc || (depth0 != null ? depth0.ItemLongDesc : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"ItemLongDesc","hash":{},"data":data}) : helper)))
    + "</p>\r\n"
    + ((stack1 = helpers['if'].call(depth0,(depth0 != null ? depth0.OrderIncrement : depth0),{"name":"if","hash":{},"fn":this.program(6, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "            <p>Item #: "
    + alias3(((helper = (helper = helpers.ItemCode || (depth0 != null ? depth0.ItemCode : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"ItemCode","hash":{},"data":data}) : helper)))
    + "</p>\r\n        </div>\r\n";
},"2":function(depth0,helpers,partials,data) {
    var helper;

  return this.escapeExpression(((helper = (helper = helpers.ItemName || (depth0 != null ? depth0.ItemName : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"ItemName","hash":{},"data":data}) : helper)));
},"4":function(depth0,helpers,partials,data) {
    var helper;

  return this.escapeExpression(((helper = (helper = helpers.ItemCodeDesc || (depth0 != null ? depth0.ItemCodeDesc : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"ItemCodeDesc","hash":{},"data":data}) : helper)));
},"6":function(depth0,helpers,partials,data) {
    var helper;

  return "                <p>Item must be ordered in multiples of "
    + this.escapeExpression(((helper = (helper = helpers.OrderIncrement || (depth0 != null ? depth0.OrderIncrement : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"OrderIncrement","hash":{},"data":data}) : helper)))
    + "</p>\r\n";
},"8":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "        <div class=\"details col-sm-9\">\r\n            <h4>"
    + ((stack1 = helpers['if'].call(depth0,(depth0 != null ? depth0.ItemName : depth0),{"name":"if","hash":{},"fn":this.program(2, data, 0),"inverse":this.program(4, data, 0),"data":data})) != null ? stack1 : "")
    + "</h4>\r\n\r\n            <p>"
    + alias3(((helper = (helper = helpers.ItemLongDesc || (depth0 != null ? depth0.ItemLongDesc : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"ItemLongDesc","hash":{},"data":data}) : helper)))
    + "</p>\r\n"
    + ((stack1 = helpers['if'].call(depth0,(depth0 != null ? depth0.OrderIncrement : depth0),{"name":"if","hash":{},"fn":this.program(6, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "            <p>Item #: "
    + alias3(((helper = (helper = helpers.ItemCode || (depth0 != null ? depth0.ItemCode : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"ItemCode","hash":{},"data":data}) : helper)))
    + "</p>\r\n        </div>\r\n";
},"10":function(depth0,helpers,partials,data) {
    return "                <div class=\"form-group form-group-sm\">\r\n                    <label class=\"col-sm-8 control-label\">Pallets:</label>\r\n\r\n                    <div class=\"pallets col-sm-4 form-control-static\" style=\"text-align: left\">0.00</div>\r\n                </div>\r\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2=this.escapeExpression;

  return "<div class=\"row\">\r\n"
    + ((stack1 = helpers['if'].call(depth0,(depth0 != null ? depth0.ImageFile : depth0),{"name":"if","hash":{},"fn":this.program(1, data, 0),"inverse":this.program(8, data, 0),"data":data})) != null ? stack1 : "")
    + "\r\n    <div class=\"item-pricing col-sm-3\">\r\n        <div class=\"form-horizontal\">\r\n            <div class=\"form-group\">\r\n                <p class=\"col-sm-12 form-control-static text-right\">$"
    + alias2((helpers.numberToFixed || (depth0 && depth0.numberToFixed) || alias1).call(depth0,(depth0 != null ? depth0.CustomerPrice : depth0),2,{"name":"numberToFixed","hash":{},"data":data}))
    + "\r\n                    / "
    + alias2(((helper = (helper = helpers.SalesUnitOfMeasure || (depth0 != null ? depth0.SalesUnitOfMeasure : depth0)) != null ? helper : alias1),(typeof helper === "function" ? helper.call(depth0,{"name":"SalesUnitOfMeasure","hash":{},"data":data}) : helper)))
    + "</p>\r\n            </div>\r\n\r\n            <div class=\"form-group form-group-sm\">\r\n                <label class=\"col-sm-8 control-label\">Qty:</label>\r\n\r\n                <div class=\"col-sm-4\">\r\n                    <input type=\"text\" class=\"quantity form-control input-sm\">\r\n                </div>\r\n            </div>\r\n\r\n"
    + ((stack1 = (helpers.compare || (depth0 && depth0.compare) || alias1).call(depth0,(depth0 != null ? depth0.UDF_IT_PER_PALLET : depth0),">",0,{"name":"compare","hash":{},"fn":this.program(10, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "\r\n            <div class=\"form-group form-group-sm\">\r\n                <div class=\"col-sm-12 control-label text-right\">\r\n                    <button class=\"add-to-cart btn btn-default btn-xs\">Add to Cart</button>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</div>\r\n";
},"useData":true});
})();