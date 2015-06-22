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

        $this->load->library(array('form_validation', 'response'));
        $this->load->model('categories_model');

        $_POST = json_decode(file_get_contents('php://input'), TRUE);
        $this->contact = $this->session->userdata('contact');
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
        // If the user is not authenticated
        if (!$this->contact) {
            $this->response->send(array('status' => 'error', 'message' => 'Unauthorized'), 401);
        }

        // Get all categories for the authenticated user
        $this->response->send($this->categories_model->getAll($this->contact));
    }


    /*
    |--------------------------------------------------------------------------
    | Non-CRUD categories actions
    |--------------------------------------------------------------------------
    */

    /**
     * Syncs the categories
     */
    public function sync() {
        // If the user is not authenticated
        if (!$this->contact) {
            $this->response->send(array('status' => 'error', 'message' => 'Unauthorized'), 401);
        }

        // Sync all categories
        $response = $this->categories_model->sync($this->contact);
        if ($response->status != 'success') {
            $this->response->send(array('status' => 'error', 'message' => 'Unable to sync categories with SAGE'), 400);
        }

        $this->response->send();
    }


    /*
    |--------------------------------------------------------------------------
    | Form validation rule callbacks
    |--------------------------------------------------------------------------
    */

}
