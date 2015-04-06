<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Methods in this controller are meant to be hit via ajax, and simply echo out the required json.
 *
 * @property mixed session
 * @author Ken
 */
class ajax extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('catalog_model', 'catalog');
        $this->load->model('product_model', 'product');
        $this->load->model('cart_model', 'cart');
        $this->load->model('mas_cart_model', 'masCart');

        // All of these responses should be json
        $this->output->set_content_type('application/json');
    }


    /**
     * Adds an item to the shopping cart of the currently logged in user
     *
     */
    public function updateCart() {
        $this->checkForLoggedIn();
        $cart = json_decode(file_get_contents('php://input'), true);
        $uid = $this->session->userdata('UID');
        $email = $this->session->userdata('EmailAddress');
        $sequenceNo = $this->session->userdata('SequenceNo');

        // Make sure we have a ShipToCode and if not use the PrimaryShipToCode as a default *** Modified: see below ***
        $localCart = $this->cart->getCart($email);
//        if ( !empty($cart['ShipToCode'])) {
//            $shipToCode = $cart['ShipToCode'];
//        } elseif (empty($localCart['ShipToCode'])) {
//            $shipToCode = $this->session->userdata('PrimaryShipToCode');
//        } else {
//            $shipToCode = $localCart['ShipToCode'];
//        }

        // Leaving shipToCode empty will cause it to default to the user's shipToCode, so we don't need this next line
//        $shipToCode = $this->session->userdata('PrimaryShipToCode');
//        $shipToCode = "";

        // If we don't have a SequenceNo we either are on a new session or we have never created the Mas Cart
        if (empty($sequenceNo)) {
            if (empty($localCart['SequenceNo'])) {
                // The cart doesn't have a SequenceNo so we should create a new cart and then add the SequenceNo
                $createResult = $this->masCart->createCart($uid, $cart["SalesOrder"]);

                $sequenceNo = $createResult->resource->SequenceNo;
            } else {
                $sequenceNo = $localCart['SequenceNo'];
            }

            // Validate data
            if (is_array($sequenceNo)) {
                $sequenceNo = $sequenceNo[0];
            }
            $this->session->set_userdata('SequenceNo', $sequenceNo);
        }

        // Update the MasCart
        $result = $this->masCart->updateCart($uid, $cart['SalesOrder'], $sequenceNo);

        if (!$result) {
            $this->error(400, 'Unable to update the cart');
        }

        // If there is no cart, mas will send back a 404 error
        if ($result->status == "error" && $result->code == '404') {
            // The cart doesn't have a SequenceNo so we should create a new cart and then add the SequenceNo
            $createResult = $this->masCart->createCart($uid, $cart["SalesOrder"]);

            // Check for errors
            if (!$createResult || $createResult->status == "error") {
                $this->error(400, 'Unable to update the cart');
            }

            // Since the correct SequenceNo was not in the session lets add it
            $sequenceNo = $createResult->resource->SequenceNo;
            $this->session->set_userdata('SequenceNo', $sequenceNo);
        }

        // Update the MongoDB Cart
        $this->cart->updateCart($email, $cart["SalesOrder"], $sequenceNo);

        $this->getCart();
    }

    public function getCart() {
        $this->checkForLoggedIn();
        $result = $this->cart->getCart($this->session->userdata('EmailAddress'));
        $encodedData = json_encode($result);
        $encodedData = str_replace('\/C', '/C', $encodedData);
        header('Content-Type: application/json');
        $this->output->set_output($encodedData);
    }

    /**
     * Submit the cart to Mas and then empty the MongoDB Cart
     */
    public function submitCart() {
        $this->checkForLoggedIn();

        $uid = $this->session->userdata('UID');
        $email = $this->session->userdata('EmailAddress');
        $sequenceNo = $this->session->userdata('SequenceNo');

        // Validate data
        if (is_array($sequenceNo)) {
            $sequenceNo = $sequenceNo[0];
        }

        $result = $this->masCart->submitCart($uid, $sequenceNo);

        if (!$result) {
            $this->error(400, 'Unable to submit the cart');
        }

        // if there is no cart, mas will send back a 404 error
        if ($result->status == "error" && $result->code == '404') {
            $localCart = $this->cart->getCart($email);
            // The cart doesn't have a SequenceNo so we should create a new cart
            $createResult = $this->masCart->createCart($uid, $localCart["SalesOrder"]);

            // Check for errors
            if (!$createResult || $createResult->status == "error") {
                $this->error(400, 'Unable to create the cart');
            }
            $sequenceNo = $createResult->resource->SequenceNo;

            // Try submitting the new cart
            $submitResult = $this->masCart->submitCart($uid, $sequenceNo);

            // Check for errors
            if (!$submitResult || $submitResult->status == "error") {
                $this->error(400, 'Unable to create the cart');
            }
        }


        // Calling update without cart info will empty it.
        $this->cart->updateCart($email);

        // Remove the SequenceNo so we can create a new cart
        $this->session->unset_userdata('SequenceNo');

        $this->output->set_output(json_encode($result));
    }

    /**
     * Gets the Mas cart if it exists if not creates the cart and returns it
     */
    public function getMasCart() {
        $this->checkForLoggedIn();
        $uid = $this->session->userdata('UID');
        $email = $this->session->userdata('EmailAddress');
        $sequenceNo = $this->session->userdata('SequenceNo');

//        // Make sure we have a ShipToCode and if not use the PrimaryShipToCode as a default
//        $localCart = $this->cart->getCart($email);
//        if (empty($localCart['ShipToCode'])) {
//            $shipToCode = $this->session->userdata('PrimaryShipToCode');
//        } else {
//            $shipToCode = $localCart['ShipToCode'];
//        }
//        $shipToCode = '';

        $cart = $this->cart->getCart($email);
        // If we don't have a SequenceNo we either are on a new session or we have never created the Mas Cart
        if (empty($sequenceNo)) {
            if (empty($cart['SequenceNo'])) {
                // The cart doesn't have a SequenceNo so we should create a new cart and then add the SequenceNo
                $createResult = $this->masCart->createCart($uid, $cart["SalesOrder"]);
                $sequenceNo = $createResult->resource->SequenceNo;

                // Lets update the MongoDB cart to include the SequenceNo
                $this->cart->updateCart($email, $cart['SalesOrder'], $sequenceNo);
            } else {
                $sequenceNo = $cart['SequenceNo'];
            }

            // Since the SequenceNo was not in the session lets add it
            $this->session->set_userdata('SequenceNo', $sequenceNo);
        }

        // Validate data
        if (is_array($sequenceNo)) {
            $sequenceNo = $sequenceNo[0];
        }

        $result = $this->masCart->getCart($uid, $sequenceNo);

        if (!$result) {
            $this->error(400, 'Unable to get cart');
        }

        // if there is no cart, mas will send back a 404 error
        if ($result->status == "error" && $result->code == '404') {
            // The cart doesn't have a SequenceNo so we should create a new cart and then add the SequenceNo
            $createResult = $this->masCart->createCart($uid, $cart["SalesOrder"]);

            // Check for errors
            if (!$createResult || $result->status == "error") {
                $this->error(400, 'Unable to create the cart');
            }

            // Lets update the MongoDB cart to include the SequenceNo
            $sequenceNo = $createResult->resource->SequenceNo;
            $this->cart->updateCart($email, $cart['SalesOrder'], $sequenceNo);

            // Since the correct SequenceNo was not in the session lets add it
            $this->session->set_userdata('SequenceNo', $sequenceNo);

            $result->resource = $cart['SalesOrder'];
        }

        $encodedData = json_encode($result);
        $encodedData = str_replace('\/C', '/C', $encodedData);
        $this->output->set_output($encodedData);
    }


    /**
     * returns json representation of entire catalog of products accessible by currently logged in user
     *
     */
    public function getCatalog() {
        $this->checkForLoggedIn();
        $catalog = $this->catalog->getByCustomer($this->session->userdata('UID'));

        if ($catalog->status == 'error') {
            $this->error($catalog->code, $catalog->message);
        }
        $this->output->set_output(json_encode($catalog->resource));

    }

    /**
     * returns json representation of currently logged in user email and name
     */
    public function getContactInfo() {
        $this->checkForLoggedIn();
        $contact = new stdClass();
        $contact->email = $this->session->userdata('EmailAddress');
        $contact->name = $this->session->userdata('ContactName');
        $this->output->set_output(json_encode($contact));
    }

    /**
     * Returns json representation of specific product
     *
     * @param string $itemCode
     */
    public function getProduct($itemCode) {
        $this->checkForLoggedIn();
        $result = $this->product->getProduct($itemCode);
        if ($result->status == 'error') {
            $this->error($result->code, $result->message);
        }
        $this->output->set_output($this->product->resource);
    }


    /**
     * The following methods are for test purposes only, and will be removed when replaced by
     * backbone.js implementation.
     *
     */

    public function getProductHtml($itemCode) {
        $this->checkForLoggedIn();
        $result = $this->product->getProduct($itemCode);
        if ($result->status == 'error') {
            $this->error($result->code, $result->message);
        }
        $product = $result->resource;
        $content = '<div style="border:2px solid black; margin:5px; padding:5px;">';
        $content .= "Item Code : $product->ItemCode <br />";
        $content .= "Ship Weight : $product->ShipWeight <br />";
        $content .= "Retail Price : $product->SuggestedRetailPrice <br />";
        $content .= "Your Price : $product->StandardUnitPrice <br />";
//        $content .= "Quantity in stock : $product->TotalQuantityOnHand <br />";

        echo $content;
    }

    public function getProductsByCategory($categoryCode) {
        $this->checkForLoggedIn();
        $catalog = $this->catalog->getByCustomer($this->session->userdata('UID'));

        if ($catalog->status == 'error') {
            $this->error($catalog->code, $catalog->message);
        }


        $products = $this->findProductsByCategory($catalog->resource, $categoryCode);
        if (!$products) {
            header("HTTP/1.0 404 Not Found");
            echo "{\"message\": \"Could not find any products for specified category.\"}";
            exit;
        }

        // create and send back HTML
        $content = '';
        foreach ($products as $product) {
            $content .= '<div class="item">';
            $content .= '<div class="image"><img src="http://placehold.it/80x80" /></div>';
            $content .= "<ul><li><b>Item Code</b> : $product->ItemCode</li>";
            $content .= "<li><b>Description</b> : $product->ItemCodeDesc</li>";
            $content .= "<li><b>Suggested Retail Price</b> : $product->SuggestedRetailPrice</li>";
            $content .= "<li><b>Total Quantity On Hand</b> : $product->TotalQuantityOnHand</li></ul>";
            $content .= '</div>';
        }

        echo $content;

    }

    /*
     * End temporary functions
     */


    /**
     * function used only internally to this class
     *
     * @param        catalog resource $catalog
     * @param string $categoryCode
     * @return product resource if found, else false
     */
    private function findProductsByCategory($catalog, $categoryCode) {
        foreach ($catalog as $category) {
            if ($category->CategoryCode == $categoryCode) {
                return $category->Products;
            }
            if (isset($category->Children)) {
                $result = $this->findProductsByCategory($category->Children, $categoryCode);
                if (!empty($result)) {
                    return $result;
                }
            }
        }
        return false;
    }

    /**
     * if there is no currently logged in user, returns unauthorized header
     */
    private function checkForLoggedIn() {
        if (!$this->session->userdata('LoggedIn')) {
            header("HTTP/1.0 401 Unauthorized");
            exit;
        }
    }

    /**
     * sets the appropriate error header code and message if an error came back from API request.
     *
     * @param string $code
     * @param string $message
     */
    private function error($code, $message) {
        switch ($code) {
            case 400:
                header("HTTP/1.0 400 Bad Request");
                break;
            case 404:
                header("HTTP/1.0 404 Not Found");
                break;
        }
        header('Content-type: application/json');
        echo "{\"message\": \"$message\"}";
        exit;
    }

    public function test() {

    }
}
