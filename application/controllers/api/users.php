<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Users
 */
class Users extends CI_Controller {

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();

        $this->load->library(array('form_validation', 'response'));
        $this->load->model('users_model');

        $_POST = json_decode(file_get_contents('php://input'), TRUE);
    }


    /*
    |--------------------------------------------------------------------------
    | contacts CRUD
    |--------------------------------------------------------------------------
    |
    | CRUD actions available to the contacts
    |
    */

    /**
     * Get a contact
     *
     * @param $user_id
     * @return string - JSON
     */
    public function get($user_id) {
        // If the $user_id is @me then we assume it's the authenticated user
        if ($user_id == '@me') {
            $contact = $this->session->userdata('contact');
        } else {
            $contact = FALSE;
        }

        // If the user is not authenticated
        if (!$contact) {
            $this->response->send(array('status' => 'error', 'message' => 'Unauthorized'), 401);
        }

        // Filter data that is sent to the front-end
        unset($contact['guid']);

        // Get the contact
        $this->response->send($contact);
    }


    /*
    |--------------------------------------------------------------------------
    | Non-CRUD contacts actions
    |--------------------------------------------------------------------------
    */

    /**
     * Authenticate the contact to the SAGE API.  Save the contact to our database.
     */
    public function login() {

        // Validate data
        $_POST = json_decode(file_get_contents('php://input'), TRUE);
        $this->form_validation->set_rules('username', 'username', 'required'); // TODO: add valid_email once we start using emails
        $this->form_validation->set_rules('password', 'password', 'required');

        // If the form did not validate
        if ($this->form_validation->run() == FALSE) {
            $this->response->send(array('status' => 'error', 'message' => $this->form_validation->error_array()), 400);
        }

        // Find the contact with the username/password combo
        $response = $this->users_model->getByEmailAndPassword($this->input->post('username'), $this->input->post('password'));

        // If there was an error
        if (isset($response->status) && $response->status == 'error') {
            $this->response->send($response, $response->code);
        }

        // Validate the contact info that is received from SAGE
        $_POST = (array)$response;
        $this->form_validation->set_rules('guid', 'GUID', 'required');
        $this->form_validation->set_rules('username', 'User Name', 'required');
        $this->form_validation->set_rules('contactname', 'Contact Name', 'required');
        $this->form_validation->set_rules('customername', 'Customer Name', 'required');
        $this->form_validation->set_rules('emailaddress', 'Email Address', 'required|valid_email');

        // If the form did not validate
        if ($this->form_validation->run() == FALSE) {
            $messages = array_merge(array('There was a problem with the contact information returned from SAGE.'), array_values($this->form_validation->error_array()));
            // TODO: Send email notification that there was a problem
            $this->response->send($messages, 400);
        }

        // Filter the data
        $contact = array(
            'guid' => $response->guid,
            'username' => $response->username,
            'contactname' => $response->contactname,
            'customername' => $response->customername,
            'emailaddress' => $response->emailaddress,
        );

        // Save the contact in the session
        $this->session->set_userdata('contact', $contact);

        // Filter data that is sent to the database and front-end
        unset($contact['guid']);

        // Update the contact info in the database
        $this->users_model->update($contact['username'], $contact);

        // Sync products and categories
        // TODO: Limit the number of times we do a sync.  Maybe once per day or have this be an asynchronous call
        $this->load->model('products_model');
        $response = $this->products_model->sync($contact);
        if ($response->status != 'success') {
            $this->response->send(array('status' => 'error', 'message' => 'Could not sync products with SAGE'), 400);
        }
        // TODO: Sync categories too

        $this->response->send($contact, 200);
    }


    /**
     * Logout the user from the session
     */
    public function logout() {
        $this->session->sess_destroy();
    }


    /*
    |--------------------------------------------------------------------------
    | Form validation rule callbacks
    |--------------------------------------------------------------------------
    */

}
