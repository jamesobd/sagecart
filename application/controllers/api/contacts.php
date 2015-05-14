<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Contacts
 */
class Contacts extends CI_Controller {

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();

        $this->load->library(array('form_validation', 'response'));
        $this->load->model('contacts_model');

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
     * @param $contact_id
     * @return string - JSON
     */
    public function get($contact_id) {
        // If the $contact_id is @me then we assume it's the authenticated user
        if ($contact_id == '@me') {
            $contact = $this->session->userdata('contact');
        } else {
            $contact = FALSE;
        }

        // If the user is not authenticated
        if (!$contact) {
            $this->response->send(array('status' => 'error', 'message' => 'Unauthorized'), 401);
        }

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
        $this->form_validation->set_rules('email', 'email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'password', 'required');

        // If the form did not validate
        if ($this->form_validation->run() == FALSE) {
            $this->response->send(array('status' => 'error', 'message' => $this->form_validation->error_array()), 400);
        }

        // Find the contact with the username/password combo
        $response = $this->contacts_model->getByEmailAndPassword($this->input->post('email'), $this->input->post('password'));

        // If there was an error
        if (isset($response->status) && $response->status == 'error') {
            $this->response->send($response, $response->code);
        }

        // Find the correct address.  This is a hack until the SAGE API gives us the correct one.
        $address = array();
        foreach ($response->ShipToAddresses as $shipToAddress) {
            if ($shipToAddress->ShipToCode == $response->shipToCode) {
                $address = $shipToAddress;
            }
        }

        // Validate the contact info that is received from SAGE
        $_POST = (array)$response;
        $this->form_validation->set_rules('UID', 'UID', 'required');
        $this->form_validation->set_rules('ContactName', 'Contact Name', '');
        $this->form_validation->set_rules('CustomerName', 'Customer Name', '');
        $this->form_validation->set_rules('UDF_IT_CATEGORY', 'UDF_IT_CATEGORY', '');

        // If the form did not validate
        if ($this->form_validation->run() == FALSE) {
            $messages = array_merge(array('There was a problem with the contact information returned from SAGE.'), array_values($this->form_validation->error_array()));
            // TODO: Send email notification that there was a problem
        }

        // Filter the data
        $contact = array(
            'UID' => $response->UID,
            'ContactName' => $response->ContactName,
            'CustomerName' => $response->CustomerName,
            'EmailAddress' => $response->EmailAddress,
            "UDF_IT_CATEGORY" => $response->UDF_IT_CATEGORY,
            'ShipToAddress' => $address,
        );

        // Update the contact info in the database
        $this->contacts_model->update($contact['EmailAddress'], $contact, array('upsert' => 'true'));

        // Sync products and categories
        $this->load->model('products_model');
        $response = $this->products_model->sync($contact);
        if ($response->status != 'success') {
            $this->response->send(array('status' => 'error', 'message' => 'Could not sync products with SAGE'), 400);
        }

        // Save the contact in the session
        $this->session->set_userdata('contact', $contact);

        // Filter data that is sent to the front-end
        unset($contact['UID']);

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
