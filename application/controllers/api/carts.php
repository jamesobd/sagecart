<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Carts
 */
class Carts extends CI_Controller {

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();

        $this->load->library(array('form_validation', 'response'));
        $this->load->model('carts_model');

        $_POST = json_decode(file_get_contents('php://input'), TRUE);
        $this->contact = $this->session->userdata('contact');
    }


    /*
    |--------------------------------------------------------------------------
    | carts CRUD
    |--------------------------------------------------------------------------
    |
    | CRUD actions available to the carts
    |
    */

    /**
     * Create a "comment carts".  Can be adapted fairly easily to handle normal carts if that is ever needed.
     */
    public function post() {
        // If the user is not authenticated
        if (!$this->contact) {
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

        $result = $this->carts_model->create($this->contact, $data);
        $this->response->send($result, 201);
    }

    /**
     * Get all carts
     *
     * @return string - JSON
     */
    public function getall() {
        // If the user is not authenticated
        if (!$this->contact) {
            $this->response->send(array('status' => 'error', 'message' => 'Unauthorized'), 401);
        }

        // Get all carts for the authenticated user
        $this->response->send($this->carts_model->getAll($this->contact));
    }

    /**
     * Atomically update carts
     *
     * @param int $carts_id
     * @return string - JSON
     */
    public function patch($carts_id) {
        // If the user is not authenticated
        if (!$this->contact) {
            $this->response->send(array('status' => 'error', 'message' => 'Unauthorized'), 401);
        }

        // Validate data
        $_POST['carts_id'] = $carts_id;
        $this->form_validation->set_rules('carts_id', 'Carts ID', 'required|_existsInContact[_Carts.ItemCode]');
        $this->form_validation->set_rules('_Quantity', 'quantity', 'is_natural');

        if ($this->form_validation->run() == FALSE) {
            $this->response->send(array('status' => 'error', 'message' => $this->form_validation->error_array()), 400);
        }

        // Filter the data
        $data = array(
            '_Quantity' => $this->input->post('_Quantity'),
        );

        $carts = $this->carts_model->update($this->contact, $carts_id, $data);
        $this->response->send($carts, 200);
    }


    /*
    |--------------------------------------------------------------------------
    | Non-CRUD carts actions
    |--------------------------------------------------------------------------
    */

    /**
     * Create a carts on SAGE, get the carts information from SAGE, then validate the data
     */
    public function checkout() {
        // If the user is not authenticated
        if (!$this->contact) {
            $this->response->send(array('status' => 'error', 'message' => 'Unauthorized'), 401);
        }

        $result = $this->carts_model->checkout($this->contact);

        // If there was an error
        if (isset($result->status) && $result->status == 'error') {
            $this->response->send($result, $result->code);
        }

        // TODO: Check the carts $result to the carts that we have in our mongo carts to see if the prices/quantities match


        $this->response->send($result);
    }


    public function submit() {
        // If the user is not authenticated
        if (!$this->contact) {
            $this->response->send(array('status' => 'error', 'message' => 'Unauthorized'), 401);
        }

        // If there is no sequence number
        $sequenceNo = $this->session->userdata('SequenceNo');
        if (empty($sequenceNo)) {
            $this->response->send(array('status' => 'error', 'message' => 'Please update totals before submitting the order.'), 400);
        }

        $result = $this->carts_model->submit($this->contact, $sequenceNo);

        // If there is a SAGE API error
        if (isset($result->status) && $result->status == 'error') {
            $this->session->unset_userdata('SequenceNo'); // We're not sure why there was an error so we unset the sequenceNo so a new one can be created
            $this->response->send($result, $result->code);
        }

        $this->session->unset_userdata('SequenceNo');
        $this->response->send($result);
    }


    /**
     * Clears the carts quantities and removes the comments field.
     */
    public function clear() {
        // If the user is not authenticated
        if (!$this->contact) {
            $this->response->send(array('status' => 'error', 'message' => 'Unauthorized'), 401);
        }

        $response = $this->carts_model->clear($this->contact);
        if ($response->status != 'success') {
            $this->response->send(array('status' => 'error', 'message' => 'Could not clear carts on SAGE'), 400);
        }

        $this->response->send();
    }


    /**
     * Syncs the carts and the carts categories
     */
    public function sync() {
        // If the user is not authenticated
        if (!$this->contact) {
            $this->response->send(array('status' => 'error', 'message' => 'Unauthorized'), 401);
        }

        // Sync all carts
        $response = $this->carts_model->sync($this->contact);
        if ($response->status != 'success') {
            $this->response->send(array('status' => 'error', 'message' => 'Unable to sync carts with SAGE'), 400);
        }

        $this->response->send();
    }


    public function test() {
        $carts = $this->carts_model->test();
        echo json_encode($carts, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /*
    |--------------------------------------------------------------------------
    | Form validation rule callbacks
    |--------------------------------------------------------------------------
    */

    private function _existsInContact($str, $field) {
        // If the user is not authorized
        if (!$this->contact) {
            $this->form_validation->set_message('_existsInContact', 'Unauthorized');
            return false;
        }

        // Count if there is $field in the contact
        $this->form_validation->set_message('_existsInContact', 'Not Found');
        return $this->carts_model->exists($this->contact, $field, $str);
    }
}
