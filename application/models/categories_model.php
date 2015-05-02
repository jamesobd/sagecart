<?php

class Categories_Model extends CI_Model {

    // Class variables
    var $collection;

    function __construct() {
        parent::__construct();

        $this->load->library(array('request'));
        // connect to the database
        $this->collection = (new MongoClient($this->config->item('mongo_uri')))->sagecart->contacts;
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
        // Get the categories from the database
        return $this->collection->findOne(array("EmailAddress" => $contact['EmailAddress']), array('_ProductCategories' => TRUE))['_ProductCategories'];
    }

    /*
    |--------------------------------------------------------------------------
    | Categories non-CRUD methods
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | Private methods
    |--------------------------------------------------------------------------
    */

}