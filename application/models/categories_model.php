<?php

class Categories_Model extends CI_Model {

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
    | Categories CRUD methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get all categories
     *
     * @param      $contact - The contact to get categories from
     * @return mixed
     */
    public function getAll($contact) {
        return $this->collection->findOne(array("username" => $contact['username']), array('categories' => TRUE))['categories'];
    }


    /*
    |--------------------------------------------------------------------------
    | Categories non-CRUD methods
    |--------------------------------------------------------------------------
    */

    /**
     * Sync categories with SAGE
     *
     * @param $contact
     * @return object - Status of sync
     */
    public function sync($contact) {
        $url = $this->config->item('sage_api_url') . 'categories';
        $response = $this->request->get($url);

        // If there was a CURL error
        if ($response->status == 'error') {
            return $response;
        }

        // If there is a SAGE API error
        if (empty($response->body) || !empty($response->body->status) && $response->body->status == 'error') {
            return (object)array(
                'status' => 'error',
                'code' => isset($response->body->code) ? $response->body->code : 500,
                'message' => isset($response->body->message) ? $response->body->message : 'Internal Server Error',
                'details' => isset($response->body->detail) ? $response->body->detail : 'The SAGE API request did not return details',
            );
        }

        // If SAGE did not return an array of categories
        if (!is_array($response->body)) {
            return (object)array(
                'status' => 'error',
                'code' => 404,
                'message' => 'Not Found',
                'details' => 'The SAGE API did not return any categories',
            );
        }

        // Filter the data
        foreach ($response->body as &$category) {
            unset($category->detail);
        }

        // Save the categories to the database
        $this->collection->update(array("username" => $contact['username']), array('$set' => array('categories' => $response->body)));

        return (object)array('status' => 'success', 'code' => 200);
    }


    /*
    |--------------------------------------------------------------------------
    | Private methods
    |--------------------------------------------------------------------------
    */
}