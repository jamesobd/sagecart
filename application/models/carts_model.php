<?php

class Carts_Model extends CI_Model {

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
    | Carts CRUD methods
    |--------------------------------------------------------------------------
    */

    /**
     * Create a cart item
     *
     * @param       $contact
     * @param array $data
     * @return mixed
     */
    public function create($contact, array $data) {
        // Build upsert query
        $updateData = array();
        foreach ($data as $key => $value) {
            $updateData['cart.$.' . $key] = $value;
        }

        // Try to upsert
        if ($data['ItemCode']) {
            $writeResults = $this->collection->update(array("EmailAddress" => $contact['EmailAddress'], "_Carts.ItemCode" => $data['ItemCode']), array('$set' => $updateData));

            // If no carts were updated we push
            if ($writeResults['n'] == 0) {
                $this->collection->update(array("EmailAddress" => $contact['EmailAddress']), array('$push' => array('_Carts' => $data)));
            }
        }

        return $data;
    }

    /**
     * Get all carts
     *
     * @param      $contact - The contact to get carts from
     * @return mixed
     */
    public function getAll($contact) {
        // Get the carts from the database
        return $this->collection->findOne(array("username" => $contact['username']), array('carts' => TRUE))['carts'];
    }

    /**
     * Get a carts
     *
     * @param     $contact
     * @param int $carts_id
     * @return mixed
     */
    public function get($contact, $carts_id) {
        $carts = $this->getAll($contact);

        foreach ($carts as $carts) {
            if ($carts['ItemCode'] == $carts_id) {
                return $carts;
            }
        }
        return array();
    }

    /**
     * Update carts
     *
     * @param       $contact    - The contact to do the update for
     * @param int   $carts_id - The carts to update
     * @param array $data       - Updated carts info
     * @return mixed
     */
    public function update($contact, $carts_id, array $data) {
        $updateData = array();
        foreach ($data as $key => $value) {
            $updateData['_Carts.$.' . $key] = $value;
        }
        $this->collection->update(array("EmailAddress" => $contact['EmailAddress'], "_Carts.ItemCode" => $carts_id), array('$set' => $updateData));
        return $this->get($contact, $carts_id);
    }

    /*
    |--------------------------------------------------------------------------
    | Carts non-CRUD methods
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

        // Get all carts for $contact
        $carts = $this->getAll($contact);

        $orderLines = array();
        foreach ($carts as $carts) {

            // Handle "comment carts"
            if ($carts['ItemCode'] === "/C") {
                $orderLines[] = array(
                    'itemCode' => $carts['ItemCode'],
                    'commentText' => str_replace('{', '%7B', str_replace('}', '%7D', str_replace('[', '%5B', str_replace(']', '%5D', str_replace('"', '%22', str_replace(',', '%2C', $carts['CommentText'])))))),
                );
            } else if (isset($carts['_Quantity']) && $carts['_Quantity'] > 0) {

                // If the quantity is not greater than 0
                $orderLines[] = array(
                    'itemCode' => $carts['ItemCode'],
                    'quantity' => (string)$carts['_Quantity'],
                );
            } else {

                // Go to the next carts
                continue;
            }
        }

        // If there are no carts in the order
        if (empty($orderLines) || sizeof($orderLines) == 1 && $orderLines[0]['itemCode'] == '/C') {
            return (object)array('status' => 'error', 'message' => 'There are no carts in the cart', 'code' => 400);
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
            // Search through the carts and find one with the same ItemCode
            foreach ($carts as $carts) {
                if ($sageProduct->ItemCode == $carts['ItemCode']) {
                    // Check if all important info is still the same
                    $cartsErrors = array();
                    if ($sageProduct->Quantity != $carts['_Quantity']) {
                        $cartsErrors[] = 'The Quantity has changed';
                    }
                    if ($sageProduct->UnitPrice != $carts['CustomerPrice']) {
                        $cartsErrors[] = 'The Customer Price has changed';
                    }
                    if (round($sageProduct->ExtensionAmt, 2) != round($carts['CustomerPrice'] * $carts['_Quantity'], 2)) {
                        $cartsErrors[] = 'The Total Price does not match the price on the system (' . $sageProduct->ExtensionAmt . ')';
                    }
                    if ($sageProduct->ItemCodeDesc != $carts['ItemCodeDesc']) {
                        $cartsErrors[] = 'The Item Title has changed';
                    }
                    if ($sageProduct->ExtendedDescriptionText != $carts['ExtendedDescriptionText']) {
                        $cartsErrors[] = 'The Item Description has changed';
                    }

                    // If there are any errors then add it to the $errorMessages array
                    if (!empty($cartsErrors)) {
                        $errorMessages[$carts['ItemCode']] = $cartsErrors;
                    }
                }
            }
        }

        // If the carts comparison check fails
        if (!empty($errorMessages)) {
            return (object)array(
                'status' => 'error',
                'code' => 409,
                'message' => 'The carts in the cart have recently changed.',
                'details' => 'The SAGE cart has different carts details than the ones are in the database',
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
     * Clears the carts quantities and removes the "comment carts".
     *
     * @param $contact
     * @return mixed
     */
    public function clear($contact) {
        $carts = $this->collection->findOne(array("EmailAddress" => $contact['EmailAddress']))['_Carts'];
        for ($i = 0; $i < sizeof($carts); $i++) {
            unset($carts[$i]['_Quantity']);

            // Remove "comment carts"
            //if ($carts[$i]['ItemCode'] == '/C') {
            //    unset($carts[$i]);
            //}
        }

        $this->collection->update(array("EmailAddress" => $contact['EmailAddress']), array('$set' => array('_Carts' => $carts)));
        return (object)array('status' => 'success', 'code' => 200);
    }


    /**
     * Sync's the SAGE carts and categories to our database
     *
     * @param $contact
     * @return object - Status of sync
     */
    public function sync($contact) {
        // Get an updated list of carts
        $url = $this->config->item('sage_api_url') . 'carts?offset=20&limit=10';
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

        if (!is_array($response->body->carts)) {
            return (object)array(
                'status' => 'error',
                'code' => 404,
                'message' => 'Not Found',
                'details' => 'The SAGE API returned no carts',
            );
        }

        // Save the carts to the database
        $this->collection->update(array("username" => $contact['username']), array('$set' => array('carts' => $response->body->carts)));

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