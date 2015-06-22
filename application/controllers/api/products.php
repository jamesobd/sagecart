<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Products
 */
class Products extends CI_Controller {

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();

        $this->load->library(array('form_validation', 'response'));
        $this->load->model('products_model');

        $_POST = json_decode(file_get_contents('php://input'), TRUE);
        $this->contact = $this->session->userdata('contact');
    }


    /*
    |--------------------------------------------------------------------------
    | products CRUD
    |--------------------------------------------------------------------------
    |
    | CRUD actions available to the products
    |
    */

    /**
     * Get all products
     *
     * @return string - JSON
     */
    public function getall() {
        // If the user is not authenticated
        if (!$this->contact) {
            $this->response->send(array('status' => 'error', 'message' => 'Unauthorized'), 401);
        }

        // Get all products for the authenticated user
        $this->response->send($this->products_model->getAll($this->contact));
    }


    /*
    |--------------------------------------------------------------------------
    | Non-CRUD products actions
    |--------------------------------------------------------------------------
    */

    /**
     * Syncs the products
     */
    public function sync() {
        // If the user is not authenticated
        if (!$this->contact) {
            $this->response->send(array('status' => 'error', 'message' => 'Unauthorized'), 401);
        }

        // Sync all products
        $response = $this->products_model->sync($this->contact);
        if ($response->status != 'success') {
            $this->response->send(array('status' => 'error', 'message' => 'Unable to sync products with SAGE'), 400);
        }

        $this->response->send();
    }


    /*
    |--------------------------------------------------------------------------
    | Form validation rule callbacks
    |--------------------------------------------------------------------------
    */

}
