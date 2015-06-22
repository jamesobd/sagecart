<?php

class Users_Model extends CI_Model {

    // Class variables
    var $collection;

    function __construct() {
        parent::__construct();

        $this->load->library(array('request'));
        $this->collection = (new MongoClient($this->config->item('mongo_uri')))->sagecart->users;
    }


    /*
    |--------------------------------------------------------------------------
    | Contacts CRUD methods
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Contacts non-CRUD methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get a contact by email and password
     *
     * @param $username
     * @param $password
     * @return mixed
     */
    public function getByUsernameAndPassword($username, $password) {
        $body = array(
            'user' => $username,
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