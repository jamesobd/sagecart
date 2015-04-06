<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: James
 * Date: 11/4/13
 * Time: 9:12 PM
 */

class Rest extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->output->set_content_type('application/json');
    }

    /**
     * Make sure the user is authenticated.  Map to appropriate function if they are.
     *
     * @param $function
     * @param array $params
     * @return mixed
     */
    function _remap($function, $params = array())
    {
        // Is the user signed in?
        if (!$this->session->userdata('LoggedIn')) {
            $this->output->set_output(json_encode(array('status' => 'error', 'message' => "You are not signed in")));
            return;
        }

        // Does the resource method exist?
        if (method_exists($this, $function)) {
            return call_user_func_array(array($this, $function), $params);
        }

        // No RESTful resource method found
        $this->output->set_output(json_encode(array('status' => 'error', 'message' => "Resource not found")));
        $this->output->set_status_header(404);
    }


    /**
     * API method: list
     * Resource: catalog
     */
    function list_catalog()
    {
        $this->load->model('catalog_model', 'catalog');
        $catalog = $this->catalog->getByCustomer($this->session->userdata('UID'));

        if ($catalog->status == 'error') {
            $this->error($catalog->code, $catalog->message);
        }
        $this->output->set_output(json_encode($catalog->resource, JSON_NUMERIC_CHECK));
    }

    /**
     * API method: list
     * Database resource: cartitems
     */
    function get_cart()
    {
        $this->load->model('cart_model');
        $cartItems = $this->cart_model->getCart($this->session->userdata('EmailAddress'));
        $this->output->set_output(json_encode($cartItems, JSON_NUMERIC_CHECK));
    }
}
