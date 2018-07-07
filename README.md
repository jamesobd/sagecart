SageCart
=

A shopping cart add-on for SAGE 100 that uses a the [SAGE Data Exchange API](http://sagedataexchange.com) to connect into SAGE.
The shopping cart is a single page app that has pre-compiled handlebars templates and caches all product data for an extremely snappy user experience.


Setup
===

* Copy `application/config/default.config.php` to `application/config/config.php`.  Modify the file as needed.

* Runs on an Apache server with PHP support.

* Also requires a MongoDB for local caching of data from the remote SAGE Data Exchange.