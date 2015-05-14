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
     * Create a "comment product".  Can be adapted fairly easily to handle normal products if that is ever needed.
     */
    public function post() {
        $contact = $this->session->userdata('contact');

        // If the user is not authenticated
        if (!$contact) {
            $this->response->send(array('status' => 'error', 'message' => 'Unauthorized'), 401);
        }

        // Validate data
        $this->form_validation->set_rules('ItemCode', 'Item Code', 'required');
        $this->form_validation->set_rules('CommentText', 'Comment Text', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->response->send(array('status' => 'error', 'message' => $this->form_validation->error_array()), 400);
        }

        // Filter the data
        $data = array(
            'ItemCode' => $this->input->post('ItemCode'),
            'CommentText' => $this->input->post('CommentText'),
        );

        $result = $this->products_model->create($contact, $data);
        $this->response->send($result, 201);
    }

    /**
     * Get all products
     *
     * @return string - JSON
     */
    public function getall() {
        $contact = $this->session->userdata('contact');

        // If the user is not authenticated
        if (!$contact) {
            $this->response->send(array('status' => 'error', 'message' => 'Unauthorized'), 401);
        }

        // Get all products for the authenticated user
        $this->response->send($this->products_model->getAll($contact));
    }

    /**
     * Atomically update products
     *
     * @param int $product_id
     * @return string - JSON
     */
    public function patch($product_id) {
        $contact = $this->session->userdata('contact');

        // If the user is not authenticated
        if (!$contact) {
            $this->response->send(array('status' => 'error', 'message' => 'Unauthorized'), 401);
        }

        // Validate data
        $_POST['product_id'] = $product_id;
        $this->form_validation->set_rules('product_id', 'Product ID', 'required|_existsInContact[_Products.ItemCode]');
        $this->form_validation->set_rules('_Quantity', 'quantity', 'is_natural');

        if ($this->form_validation->run() == FALSE) {
            $this->response->send(array('status' => 'error', 'message' => $this->form_validation->error_array()), 400);
        }

        // Filter the data
        $data = array(
            '_Quantity' => $this->input->post('_Quantity'),
        );

        $product = $this->products_model->update($contact, $product_id, $data);
        $this->response->send($product, 200);
    }


    /*
    |--------------------------------------------------------------------------
    | Non-CRUD products actions
    |--------------------------------------------------------------------------
    */

    /**
     * Create a cart on SAGE, get the cart information from SAGE, then validate the data
     */
    public function checkout() {
        $contact = $this->session->userdata('contact');

        // If the user is not authenticated
        if (!$contact) {
            $this->response->send(array('status' => 'error', 'message' => 'Unauthorized'), 401);
        }

        $result = $this->products_model->checkout($contact);

        // If there was an error
        if (isset($result->status) && $result->status == 'error') {
            $this->response->send($result, $result->code);
        }

        // TODO: Check the cart $result to the products that we have in our mongo cart to see if the prices/quantities match


        $this->response->send($result);
    }


    public function submit() {
        $contact = $this->session->userdata('contact');

        // If the user is not authenticated
        if (!$contact) {
            $this->response->send(array('status' => 'error', 'message' => 'Unauthorized'), 401);
        }

        // If there is no sequence number
        $sequenceNo = $this->session->userdata('SequenceNo');
        if (empty($sequenceNo)) {
            $this->response->send(array('status' => 'error', 'message' => 'Please update totals before submitting the order.'), 400);
        }

        $result = $this->products_model->submit($contact, $sequenceNo);

        // If there is a SAGE API error
        if (isset($result->status) && $result->status == 'error') {
            $this->session->unset_userdata('SequenceNo'); // We're not sure why there was an error so we unset the sequenceNo so a new one can be created
            $this->response->send($result, $result->code);
        }

        $this->session->unset_userdata('SequenceNo');
        $this->response->send($result);
    }


    /**
     * Clears the product quantities and removes the comments field.
     */
    public function clear() {
        $contact = $this->session->userdata('contact');

        // If the user is not authenticated
        if (!$contact) {
            $this->response->send(array('status' => 'error', 'message' => 'Unauthorized'), 401);
        }

        $response = $this->products_model->clear($contact);
        if ($response->status != 'success') {
            $this->response->send(array('status' => 'error', 'message' => 'Could not clear cart on SAGE'), 400);
        }

        $this->response->send();
    }


    /**
     * Syncs the products and the product categories
     */
    public function sync() {
        $contact = $this->session->userdata('contact');

        // If the user is not authenticated
        if (!$contact) {
            $this->response->send(array('status' => 'error', 'message' => 'Unauthorized'), 401);
        }

        $response = $this->products_model->sync($contact);
        if ($response->status != 'success') {
            $this->response->send(array('status' => 'error', 'message' => 'Could not sync with SAGE'), 400);
        }

        $this->response->send();
    }


    public function test() {
        $products = $this->products_model->test();
        echo json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /*
    |--------------------------------------------------------------------------
    | Form validation rule callbacks
    |--------------------------------------------------------------------------
    */

    private function _existsInContact($str, $field) {
        $contact = $this->session->userdata('contact');

        // If the user is not authorized
        if (!$contact) {
            $this->form_validation->set_message('_existsInContact', 'Unauthorized');
            return false;
        }

        // Count if there is $field in the contact
        $this->form_validation->set_message('_existsInContact', 'Not Found');
        return $this->products_model->exists($contact, $field, $str);
    }
}
