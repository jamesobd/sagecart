<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Methods in this controller are meant to be hit via ajax, and simply echo out the required json.
 *
 * @author Ken
 */
class Page extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('catalog_model', 'catalog');
        $this->load->model('product_model', 'product');
        $this->load->model('cart_model', 'cart');
        $this->load->model('mas_cart_model', 'masCart');
    }

    /**
     * Returns the confirm page
     */
    public function confirm() {
        $this->load->view('confirm');
    }
}
