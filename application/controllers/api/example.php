<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class _Resource_
 */
class _Resource_ extends CI_Controller {

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();

        $this->load->library('json_api_response');
        $this->load->model('_resource__model');

        $_POST = json_decode(file_get_contents('php://input'), TRUE);
    }


    /*
    |--------------------------------------------------------------------------
    | _resource_ CRUD
    |--------------------------------------------------------------------------
    |
    | CRUD actions available to the _resource_
    |
    */

    /**
     * Create _resource_
     *
     * @return string - JSON
     */
    public function post() {
        // TODO: Validate data
        $this->form_validation->set_rules('email', 'email', 'valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->json_api_response->send(array('status' => 'error', 'message' => $this->form_validation->error_array()), 400);
        }

        // TODO: Filter the data
        $data = array(
            'email' => $this->input->post('email'),
        );

        $result = $this->_resource__model->create($data);
        $this->json_api_response->send($result, 201);
    }

    /**
     * Get all _resource_s
     *
     * @return string - JSON
     */
    public function getall() {
        // TODO: Validate data
        if ($this->form_validation->run() == FALSE) {
            $this->json_api_response->send(array('status' => 'error', 'message' => $this->form_validation->error_array()), 400);
        }

        $this->json_api_response->send($this->_resource__model->getAll());
    }

    /**
     * Get _resource_
     *
     * @param int $_resource__id
     * @return string - JSON
     */
    public function get($_resource__id) {
        // TODO: Validate data
        $_POST['_resource__id'] = $_resource__id;
        $this->form_validation->set_rules('_resource__id', '_resource_', 'required|integer|exists[_resource_.id]');

        if ($this->form_validation->run() == FALSE) {
            $this->json_api_response->send(array('status' => 'error', 'message' => $this->form_validation->error_array()), 400);
        }

        $this->json_api_response->send($this->_resource__model->get($_resource__id));
    }

    /**
     * Update _resource_
     *
     * @param int $_resource__id
     * @return string - JSON
     */
    public function put($_resource__id) {
        // TODO: Validate data
        $_POST = parent::put(); // TODO: Fix this to handle GET data.
        $_POST['_resource__id'] = $_resource__id;
        $this->form_validation->set_rules('_resource__id', '_resource_', 'required|integer|exists[_resource_.id]');
        $this->form_validation->set_rules('email', 'email', 'valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->json_api_response->send(array('status' => 'error', 'message' => $this->form_validation->error_array()), 400);
        }

        // TODO: Filter the data
        $data = array(
            'email' => $this->input->post('email'),
        );

        $this->_resource__model->update($_resource__id, $data);
        $this->json_api_response->send(204);

        $this->json_api_response->send(array('status' => 'error', 'message' => 'You are forbidden from accessing _resource_'), 403);
    }

    /**
     * Atomically update _resource_
     *
     * @param int $_resource__id
     * @return string - JSON
     */
    public function patch($_resource__id) {
        // TODO: Validate data
        $_POST = parent::patch(); // TODO: Fix this to handle PATCH data.
        $_POST['_resource__id'] = $_resource__id;
        $this->form_validation->set_rules('_resource__id', '_resource_', 'required|integer|exists[_resource_.id]');
        $this->form_validation->set_rules('email', 'email', 'valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->json_api_response->send(array('status' => 'error', 'message' => $this->form_validation->error_array()), 400);
        }

        // TODO: Filter the data
        $data = array(
            'email' => $this->input->post('email'),
        );

        $this->_resource__model->update($_resource__id, $data);
        $this->json_api_response->send(204);
    }

    /**
     * Delete _resource_
     *
     * @param int $_resource__id
     * @return void
     */
    public function delete($_resource__id) {
        // TODO: Validate data
        $_POST['_resource__id'] = $_resource__id;
        $this->form_validation->set_rules('_resource__id', '_resource_', 'required|integer|exists[_resource_.id]');

        if ($this->form_validation->run() == FALSE) {
            $this->json_api_response->send(array('status' => 'error', 'message' => $this->form_validation->error_array()), 400);
        }

        $this->_resource__model->delete($_resource__id);
        $this->json_api_response->send(204);
    }


    /*
    |--------------------------------------------------------------------------
    | Non-CRUD _resource_ actions
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | Form validation rule callbacks
    |--------------------------------------------------------------------------
    */

}
