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
                        <div id="logout">
                                <span id="cart"></span>
                                <span class="divider">|</span>
                            <span id="name">Frank Sinatra</span>
                            <span class="divider">|</span>
                            <a href="/logout">Logout</a>
                        </div>
					<div id="search">
						<span id="search-logo" class="glyphicon glyphicon-search"></span>
						<input type="text" id="search-text" placeholder="Search" />
						<input type="button" id="search-button" value="Go" />
					</div>
				</div>
			</div>
		</div>
		
		<section class="container">
            <div class="row">
                <div class="col-md-2 home-link-div">
                    <a id="home-link-fixedflex" href="<?php echo $homeLink; ?>">
                        <img src="../img/gulf-packaging-logo-2.png" alt="logo">
                    </a>
                </div>
                <div class="col-md-10"></div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <nav id="main-nav"></nav>
                </div>
                <div class="col-sm-10">
                    <div id="content">
                        <div id="product-list-description" class="product-list-description"><?php echo $content; ?></div>
                        <div id="product-list-wrapper" class="product-list-wrapper row"></div>
                    </div>
                </div>
            </div>
        </section>

        <footer id="footer">
            <div class="container text-center">
                <div id="the-local-national-people"><span id="the-local">The Local  </span><span id="national-people">National People</span></div>
                <div id="footer-body">
                    <div><p id="copyright">&copy;<?php echo date("Y"); ?> Gulf Packaging</p></div>
                </div>
            </div>
        </footer>

        <div class="modal-backdrop fade in" style="display: block"></div>

        <?php echo $this->load->view('javascript_templates'); ?>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script>
			window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>');
		</script>

        <script src="/js/vendor/q.js"></script>
		<script src="/js/vendor/modernizr-2.6.2.min.js"></script>
		<script src="/js/vendor/underscore-min.js"></script>
		<script src="/js/vendor/handlebars.js"></script>
		<script src="/js/vendor/backbone-min.js"></script>
		<script src="/js/vendor/bootstrap.min.js"></script>
        <script src="/js/vendor/spin.js"></script>
        <script src="/js/vendor/math.min.js"></script>
		<script src="/js/models.js"></script>
		<script type="text/javascript">
			$(function () {
				// Get the catalog from the server
				App.products = new App.Collections.Products(); // Collection of ALL products available.  Used for cart.
                App.catalog = new App.Models.Catalog(<?php echo json_encode($catalog); ?>, {parse: true});
				App.contact = new App.Models.Contact(<?php echo json_encode($contact); ?>, {parse: true});
			});
        </script>
		<script src="/js/main.js"></script>
    </body>
</html>