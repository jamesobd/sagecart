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
			<div class="container">
				<div id="header" class="navbar-header">
					<a id="home-link" href="<?php echo $homeLink; ?>">
						<img src="../img/gulf-packaging--2.png" alt="logo">
					</a>
				</div>
			 </div>
		</div>

		<section class="container">
<!--            <script>$('.modal-backdrop').css({"display":"block"});</script>-->
			<div id="content"><?php echo $content; ?></div>
        </section>
        <footer id="footer">
            <div class="container text-center">
                <div id="the-local-national-people"><span id="the-local">The Local  </span><span id="national-people">National People</span></div>
                <div id="footer-body">
                    <div><p id="copyright">&copy;<?php echo date("Y"); ?> Gulf Packaging</p></div>
<!--                    <div id="learn-how-we-can-help">-->
<!--                        <p>Learn how we can help.</p>-->
<!--                    </div>-->
                </div>
            </div>
        </footer>

        <div class="modal-backdrop fade in" style="display: none"></div>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script>
			window.jQuery || document.write('<script src="/js/vendor/jquery-1.9.1.min.js"><\/script>');
		</script>

		<script src="/js/vendor/bootstrap.min.js"></script>

	</body>
</html>