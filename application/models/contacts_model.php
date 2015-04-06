<?php

class Contacts_Model extends CI_Model {

    // Class variables
    var $collection;

    function __construct() {
        parent::__construct();

        $this->load->library(array('mongo_db', 'request'));
        // connect to the database
        $this->collection = (new MongoClient())->gulf->contacts;
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
        $this->db->insert('contacts', $data);
        $data['id'] = $this->db->insert_id();
        return $data;
    }

    /**
     * Get all contactss
     *
     * @param array $where - optional where clauses for doing filtering
     * @return mixed
     */
    public function getAll($where = array()) {
        return $this->db->get_where('contacts', $where)->result();
    }

    /**
     * Get contacts
     *
     * @param int $contacts_id
     * @return mixed
     */
    public function get($contacts_id) {

    }

    /**
     * Update contacts
     *
     * @param int   $contacts_id
     * @param array $data
     * @return bool
     */
    public function update($contacts_id, array $data) {
        $this->collection->update(array("EmailAddress" => $contacts_id), array('$set' => $data), array('upsert' => true));
    }

    /**
     * Delete contacts
     *
     * @param int $contacts_id
     * @return bool
     */
    public function delete($contacts_id) {
        $this->db->where('contacts.id', $contacts_id)
            ->delete('contacts');
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
            'EmailAddress' => $email,
            'Password' => $password,
        );
        $url = $this->config->item('sage_api_url') . 'contact?Method=login';

        $response = $this->request->post($url, $body);

        // If there was a CURL error
        if ($response->status == 'error') {
            return $response;
        }

        // If there is a MAS API error
        if (empty($response->body) || !empty($response->body->status) && $response->body->status == 'error') {
            return (object)array(
                'status' => 'error',
                'code' => isset($response->body->code) ? $response->body->code : 500,
                'message' => isset($response->body->message) ? $response->body->message : 'Internal Server Error',
                'details' => isset($response->body->detail) ? $response->body->detail : 'The MAS API request did not return details',
            );
        }

        return $response->body->resource;
    }

}