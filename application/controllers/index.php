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
        $this->load->library(array('form_validation', 'response'));
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
     * Index Page for this controller.
     * -------------------------------------------------------------------------
     */
    public function contactus() {
        // Validate data
        $_POST = json_decode(file_get_contents('php://input'), TRUE);
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email');
        $this->form_validation->set_rules('message', 'message', 'required');

        // If the form did not validate
        if ($this->form_validation->run() == FALSE) {
            $this->response->send(array('status' => 'error', 'message' => $this->form_validation->error_array()), 400);
        }

        // Send the email
        $to = "james+test@obdstudios.com";
        $subject = 'SAGE Cart Demo - Contact Submission';
        $message = $this->input->post('message');
        $headers = 'From: ' . $this->input->post('name') . '<' . $this->input->post('email') . '>';
        mail($to, $subject, $message, $headers);
        $this->response->send();
    }


    /**
     * -------------------------------------------------------------------------
     * Testing functions
     * -------------------------------------------------------------------------
     */

}

