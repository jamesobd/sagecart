<?php

class Products_Model extends CI_Model {

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
    | Products CRUD methods
    |--------------------------------------------------------------------------
    */

    /**
     * Create a product
     *
     * @param       $contact
     * @param array $data
     * @return mixed
     */
    public function create($contact, array $data) {
        // Try to update
        $updateData = array();
        foreach ($data as $key => $value) {
            $updateData['_Products.$.' . $key] = $value;
        }

        // Try to update the "comment product"
        if ($data['ItemCode']) {
            $writeResults = $this->collection->update(array("EmailAddress" => $contact['EmailAddress'], "_Products.ItemCode" => $data['ItemCode']), array('$set' => $updateData));

            // If no products were updated we push
            if ($writeResults['n'] == 0) {
                $this->collection->update(array("EmailAddress" => $contact['EmailAddress']), array('$push' => array('_Products' => $data)));
            }
        }

        return $data;
    }

    /**
     * Get all products
     *
     * @param      $contact - The contact to get products from
     * @return mixed
     */
    public function getAll($contact) {
        // Get the products from the database
        return $this->collection->findOne(array("username" => $contact['username']), array('products' => TRUE))['products'];
    }

    /**
     * Get a product
     *
     * @param     $contact
     * @param int $product_id
     * @return mixed
     */
    public function get($contact, $product_id) {
        $products = $this->getAll($contact);

        foreach ($products as $product) {
            if ($product['ItemCode'] == $product_id) {
                return $product;
            }
        }
        return array();
    }

    /**
     * Update products
     *
     * @param       $contact    - The contact to do the update for
     * @param int   $product_id - The product to update
     * @param array $data       - Updated product info
     * @return mixed
     */
    public function update($contact, $product_id, array $data) {
        $updateData = array();
        foreach ($data as $key => $value) {
            $updateData['_Products.$.' . $key] = $value;
        }
        $this->collection->update(array("EmailAddress" => $contact['EmailAddress'], "_Products.ItemCode" => $product_id), array('$set' => $updateData));
        return $this->get($contact, $product_id);
    }

    /*
    |--------------------------------------------------------------------------
    | Products non-CRUD methods
    |--------------------------------------------------------------------------
    */

    /**
     * Create a MAS cart (or update an existing one) and get details about the cart back from MAS
     *
     * @param $contact
     * @return object
     */
    public function checkout($contact) {

        // If the sequenceNo does not exist then we create a new MAS cart
        $sequenceNo = $this->session->userdata('SequenceNo');
        if ($sequenceNo) {
            $url = $this->config->item('sage_api_url') . 'cart?Method=update&UID=' . $contact['UID'] . '&SequenceNo=' . $sequenceNo;
        } else {
            $url = $this->config->item('sage_api_url') . 'cart?Method=insert&UID=' . $contact['UID'];
        }

        // Get all products for $contact
        $products = $this->getAll($contact);

        $orderLines = array();
        foreach ($products as $product) {

            // Handle "comment products"
            if ($product['ItemCode'] === "/C") {
                $orderLines[] = array(
                    'itemCode' => $product['ItemCode'],
                    'commentText' => str_replace('{', '%7B', str_replace('}', '%7D', str_replace('[', '%5B', str_replace(']', '%5D', str_replace('"', '%22', str_replace(',', '%2C', $product['CommentText'])))))),
                );
            } else if (isset($product['_Quantity']) && $product['_Quantity'] > 0) {

                // If the quantity is not greater than 0
                $orderLines[] = array(
                    'itemCode' => $product['ItemCode'],
                    'quantity' => (string)$product['_Quantity'],
                );
            } else {

                // Go to the next product
                continue;
            }
        }

        // If there are no products in the order
        if (empty($orderLines) || sizeof($orderLines) == 1 && $orderLines[0]['itemCode'] == '/C') {
            return (object)array('status' => 'error', 'message' => 'There are no products in the cart', 'code' => 400);
        } else {
            $data['OrderLines'] = $orderLines;
        }

        $response = $this->request->post($url, $data);

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

        // Save the SequenceNo
        $this->session->set_userdata('SequenceNo', $response->body->resource->SequenceNo);
        $sequenceNo = $response->body->resource->SequenceNo;

        // Get the cart information from MAS (tax, freight, etc)
        $url = $this->config->item('sage_api_url') . 'cart?Method=get&UID=' . $contact['UID'] . '&SequenceNo=' . $sequenceNo;
        $response = $this->request->get($url);

        // If there was a CURL error
        if ($response->status == 'error') {
            return $response;
        }

        // If there is a MAS API error
        if (!isset($response->body) || isset($response->body->status) && $response->body->status == 'error') {
            return (object)array(
                'status' => 'error',
                'code' => isset($response->body->code) ? $response->body->code : 500,
                'message' => isset($response->body->message) ? $response->body->message : 'Internal Server Error',
                'details' => isset($response->body->detail) ? $response->body->detail : 'The MAS API request did not return details',
            );
        }

        // Compare the cart from SAGE to the cart in the database for comparison discrepancies
        $errorMessages = array();
        foreach ($response->body->resource->Detail as &$sageProduct) {
            // Search through the products and find one with the same ItemCode
            foreach ($products as $product) {
                if ($sageProduct->ItemCode == $product['ItemCode']) {
                    // Check if all important info is still the same
                    $productErrors = array();
                    if ($sageProduct->Quantity != $product['_Quantity']) {
                        $productErrors[] = 'The Quantity has changed';
                    }
                    if ($sageProduct->UnitPrice != $product['CustomerPrice']) {
                        $productErrors[] = 'The Customer Price has changed';
                    }
                    if (round($sageProduct->ExtensionAmt, 2) != round($product['CustomerPrice'] * $product['_Quantity'], 2)) {
                        $productErrors[] = 'The Total Price does not match the price on the system (' . $sageProduct->ExtensionAmt . ')';
                    }
                    if ($sageProduct->ItemCodeDesc != $product['ItemCodeDesc']) {
                        $productErrors[] = 'The Item Title has changed';
                    }
                    if ($sageProduct->ExtendedDescriptionText != $product['ExtendedDescriptionText']) {
                        $productErrors[] = 'The Item Description has changed';
                    }

                    // If there are any errors then add it to the $errorMessages array
                    if (!empty($productErrors)) {
                        $errorMessages[$product['ItemCode']] = $productErrors;
                    }
                }
            }
        }

        // If the product comparison check fails
        if (!empty($errorMessages)) {
            return (object)array(
                'status' => 'error',
                'code' => 409,
                'message' => 'The products in the cart have recently changed.',
                'details' => 'The SAGE cart has different product details than the ones are in the database',
            );
        }

        return $response->body->resource;
    }


    public function submit($contact, $sequenceNo) {
        $url = $this->config->item('sage_api_url') . 'cart?Method=submit&UID=' . $contact['UID'] . '&SequenceNo=' . $sequenceNo;
        $response = $this->request->get($url);

        // If there was a CURL error
        if ($response->status == 'error') {
            return $response;
        }

        // If there is a SAGE API error
        if (!isset($response->body) || isset($response->body->status) && $response->body->status == 'error') {
            return (object)array(
                'status' => 'error',
                'code' => isset($response->body->code) ? $response->body->code : 500,
                'message' => isset($response->body->message) ? $response->body->message : 'The cart could not be submitted.  Please update totals.',
                'details' => isset($response->body->detail) ? $response->body->detail : 'The MAS API request did not return details',
            );
        }

        return $response->body;
    }

    /**
     * Clears the product quantities and removes the "comment product".
     *
     * @param $contact
     * @return mixed
     */
    public function clear($contact) {
        $products = $this->collection->findOne(array("EmailAddress" => $contact['EmailAddress']))['_Products'];
        for ($i = 0; $i < sizeof($products); $i++) {
            unset($products[$i]['_Quantity']);

            // Remove "comment product"
            //if ($products[$i]['ItemCode'] == '/C') {
            //    unset($products[$i]);
            //}
        }

        $this->collection->update(array("EmailAddress" => $contact['EmailAddress']), array('$set' => array('_Products' => $products)));
        return (object)array('status' => 'success', 'code' => 200);
    }


    /**
     * Sync's the SAGE products and categories to our database
     *
     * @param $contact
     * @return object - Status of sync
     */
    public function sync($contact) {
        // Get an updated list of products
        $url = $this->config->item('sage_api_url') . 'products?offset=20&limit=10';
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

        if (!is_array($response->body)) {
            return (object)array(
                'status' => 'error',
                'code' => 404,
                'message' => 'Not Found',
                'details' => 'The SAGE API returned no products',
            );
        }

        // Save the products to the database
        $this->collection->update(array("username" => $contact['username']), array('$set' => array('products' => $response->body)));

        return (object)array('status' => 'success', 'code' => 200);
    }


    /**
     * Check to see if the $field with value $str exists in the $contact
     *
     * @param $contact - The contact
     * @param $field   - The field to check for
     * @param $str     - The value that $field should match
     * @return bool
     */
    public function exists($contact, $field, $str) {
        return $this->collection->find(array("EmailAddress" => $contact['EmailAddress'], $field => array('$eq' => $str)))->limit(1)->count(TRUE) === 1;
    }


    /*
    |--------------------------------------------------------------------------
    | Private methods
    |--------------------------------------------------------------------------
    */
}