<?php

class Products_Model extends CI_Model {

    // Class variables
    var $collection;

    function __construct() {
        parent::__construct();

        $this->load->library(array('request'));
        $this->collection = (new MongoClient($this->config->item('mongo_uri')))->sagecart->users;
    }


    /*
    |--------------------------------------------------------------------------
    | Products CRUD methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get all products
     *
     * @param      $contact - The contact to get products from
     * @return mixed
     */
    public function getAll($contact) {
        return $this->collection->findOne(array("username" => $contact['username']), array('products' => TRUE))['products'];
    }


    /*
    |--------------------------------------------------------------------------
    | Products non-CRUD methods
    |--------------------------------------------------------------------------
    */

    /**
     * Sync products with SAGE
     *
     * @param $contact
     * @return object - Status of sync
     */
    public function sync($contact) {
        $url = $this->config->item('sage_api_url') . 'products?itemType=1';
        $response = $this->request->get($url);

        // If there was a CURL error
        if ($response->status == 'error') {
            return $response;
        }

        // If there is a SAGE API error
        if (empty($response->body) || isset($response->body->status) && $response->body->status == 'error') {
            return (object)array(
                'status' => 'error',
                'code' => isset($response->body->code) ? $response->body->code : 500,
                'message' => isset($response->body->message) ? $response->body->message : 'Internal Server Error',
                'details' => isset($response->body->detail) ? $response->body->detail : 'The SAGE API request did not return details',
            );
        }

        // If SAGE did not return an array of products
        if (!is_array($response->body)) {
            return (object)array(
                'status' => 'error',
                'code' => 404,
                'message' => 'Not Found',
                'details' => 'The SAGE API did not return any products',
            );
        }

        // Save the products to the database
        $this->collection->update(array("username" => $contact['username']), array('$set' => array('products' => $response->body)));

        return (object)array('status' => 'success', 'code' => 200);
    }


    /*
    |--------------------------------------------------------------------------
    | Private methods
    |--------------------------------------------------------------------------
    */
}