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
        $contact = $this->session->userdata('contact');

        $this->load->view('home');
    }


    public function shop() {
        $contact = $this->session->userdata('contact');

        // If the user is not authenticated
        if (!$contact) {
            $this->load->view('shop');
        } else {
            redirect('/', 'refresh');
        }
    }

    /**
     * -------------------------------------------------------------------------
     * Testing functions
     * -------------------------------------------------------------------------
     */

}

