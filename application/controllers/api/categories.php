<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Categories
 */
class Categories extends CI_Controller {

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();

        $this->load->library('response');
        $this->load->model('categories_model');

        $_POST = json_decode(file_get_contents('php://input'), TRUE);
    }


    /*
    |--------------------------------------------------------------------------
    | categories CRUD
    |--------------------------------------------------------------------------
    |
    | CRUD actions available to the categories
    |
    */

    /**
     * Get all categories
     *
     * @return string - JSON
     */
    public function getall() {
        $contact = $this->session->userdata('contact');

        // If the user is not authenticated
        if (!$contact) {
            $this->response->send(array('status' => 'error', 'message' => 'Unauthorized'), 401);
        }

        // Get all categories for the authenticated user
        $this->response->send($this->categories_model->getAll($contact));
    }


    /*
    |--------------------------------------------------------------------------
    | Non-CRUD categories actions
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | Form validation rule callbacks
    |--------------------------------------------------------------------------
    */

}
