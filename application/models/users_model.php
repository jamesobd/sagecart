<?php

class Users_Model extends CI_Model {

    // Class variables
    var $collection;

    function __construct() {
        parent::__construct();

        $this->load->library(array('request'));
        // connect to the database
        $this->collection = (new MongoClient($this->config->item('mongo_uri')))->sagecart->users;
    }


    /*
    |--------------------------------------------------------------------------
    | Contacts CRUD methods
    |--------------------------------------------------------------------------
    */

    /**
     * Create contacts
     *
     * @param Object $data
     * @return mixed
     */
    public function create(Object $data) {
    }

    /**
     * Get all contactss
     *
     * @param array $where - optional where clauses for doing filtering
     * @return mixed
     */
    public function getAll($where = array()) {
    }

    /**
     * Get contacts
     *
     * @param string $users_id
     * @return mixed
     */
    public function get($users_id) {

    }

    /**
     * Update contacts
     *
     * @param int   $users_id
     * @param array $data
     * @return bool
     */
    public function update($users_id, array $data) {
        $this->collection->update(array("username" => $users_id), array('$set' => $data), array('upsert' => true));
    }

    /**
     * Delete contacts
     *
     * @param int $users_id
     * @return bool
     */
    public function delete($users_id) {
    }

    /*
    |--------------------------------------------------------------------------
    | Contacts non-CRUD methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get a contact by email and password
     *
     * @param $email
     * @param $password
     * @return mixed
     */
    public function getByEmailAndPassword($email, $password) {
        $body = array(
            'user' => $email,
            'password' => $password,
        );
        $url = $this->config->item('sage_api_url') . 'users?method=login';

        $response = $this->request->post($url, $body);

        // If there was a CURL error
        if ($response->status == 'error') {
            return $response;
        }

        // If there is a MAS API error
        if (empty($response->body) || isset($response->body->status) && $response->body->status == 'error') {
            return (object)array(
                'status' => 'error',
                'code' => isset($response->body->code) ? $response->body->code : 500,
                'message' => isset($response->body->message) ? $response->body->message : 'Internal Server Error',
                'details' => isset($response->body->detail) ? $response->body->detail : 'The MAS API request did not return details',
            );
        }

        return $response->body;
    }

}