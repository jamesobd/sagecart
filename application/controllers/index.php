<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index extends CI_Controller {


    /**
     * -------------------------------------------------------------------------
     * Constructor
     * -------------------------------------------------------------------------
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    /**
     * -------------------------------------------------------------------------
     * Index Page for this controller.
     * -------------------------------------------------------------------------
     */
    public function index() {
        $this->load->view('main');
    }


    /**
     * -------------------------------------------------------------------------
     * Testing functions
     * -------------------------------------------------------------------------
     */

}

