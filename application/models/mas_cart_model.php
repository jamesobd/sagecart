<?php

/**
 * Description of mas_cart_model
 *
 * @author Jed copied from Ken's
 */
class Mas_Cart_model extends CI_Model
{

    private $collection = 'cart';
    private $baseUri;
    private $curlSession;
    private $url;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->baseUri = 'cart';
        $this->url = $this->config->item('sage_api_url') . $this->baseUri;
        // Setup an initial curl session we may want to look into setting up keep alive
        // so we only need one socket per php session.
        $this->curlSession = curl_init();
        // We want a string instead of a boolean
        curl_setopt($this->curlSession, CURLOPT_RETURNTRANSFER, true);
        $this->load->helper('uri_helper');
    }

    /**
     * Updates the cart with the passed sequence number to be like the sales order passed in.
     * @param $uid
     * @param $salesOrder
     * @param $sequenceNo
     *
     * @return mixed
     */
    public function updateCart($uid, $salesOrder, $sequenceNo)
    {
        $data = array(
            'Method' => 'update',
            'UID' => $uid,
            'SequenceNo' => $sequenceNo
        );

        // The url needs the Method and UID params
        $url = $this->url . buildUriString($data);

        // Remove extra values from the array
        $orderLines = array();
        foreach ($salesOrder as $line) {
            if ($line['ItemCode'] === "/C") {
                $orderLines[] = array(
                    'itemCode' => "/C",
                    'commentText' => str_replace('{', '%7B', str_replace('}', '%7D', str_replace('[', '%5B', str_replace(']', '%5D', str_replace('"', '%22', str_replace(',', '%2C', $line['CommentText']))))))
                );
            } else {
                $orderLines[] = array(
                    'itemCode' => $line['ItemCode'],
                    'quantity' => (string)$line['_Quantity']
                );
            }
        }

        // We still need the Method and UID in the body so we just add the additional data here
        if ( !empty($orderLines)) {
            $data['OrderLines'] = $orderLines;
        }


        $encodedData = json_encode($data);
        $encodedData = str_replace('\/C', '/C', $encodedData);

        curl_setopt($this->curlSession, CURLOPT_URL, $url);
        curl_setopt($this->curlSession, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($this->curlSession, CURLOPT_POSTFIELDS, $encodedData);
        $response = curl_exec($this->curlSession);
        log_curl($this->curlSession, $response, $encodedData);
        return json_decode($response);
    }

    /**
     * @param $uid
     * @return array
     */
    public function getCartList($uid)
    {
        $data = array(
            'Method' => 'get',
            'UID' => $uid
        );

        // The url needs the Method and UID params
        $url = $this->url . buildUriString($data);

        curl_setopt($this->curlSession, CURLOPT_URL, $url);
        curl_setopt($this->curlSession, CURLOPT_CONNECTTIMEOUT, 60);
        $response = curl_exec($this->curlSession);
        log_curl($this->curlSession, $response);
        return json_decode($response);
    }

    /**
     * @param $uid
     * @param $sequenceNo
     * @return array
     */
    public function getCart($uid, $sequenceNo)
    {
        $data = array(
            'Method' => 'get',
            'UID' => $uid,
            'SequenceNo' => $sequenceNo
        );

        // The url needs the Method and UID params
        $url = $this->url . buildUriString($data);

        curl_setopt($this->curlSession, CURLOPT_URL, $url);
        curl_setopt($this->curlSession, CURLOPT_CONNECTTIMEOUT, 60);
        $response = curl_exec($this->curlSession);
        log_curl($this->curlSession, $response);
        return json_decode($response);
    }

    /**
     * Create new sales order (cart) on the mas server
     *
     * @param $uid
     * @param $salesOrder
     * @return array contactInformation
     */
    public function createCart($uid, $salesOrder)
    {
        $data = array(
            'Method' => 'insert',
            'UID' => $uid,
        );

        // The url needs the Method and UID params
        $url = $this->url . buildUriString($data);

        // Remove extra values from the array
        $orderLines = array();
        foreach ($salesOrder as $line) {
            if ($line['ItemCode'] === "/C") {
                $orderLines[] = array(
                    'itemCode' => $line['ItemCode'],
                    'commentText' => str_replace('{', '%7B', str_replace('}', '%7D', str_replace('[', '%5B', str_replace(']', '%5D', str_replace('"', '%22', str_replace(',', '%2C', $line['CommentText'])))))),
                );
            } else {
                $orderLines[] = array(
                    'itemCode' => $line['ItemCode'],
                    'quantity' => (string)$line['_Quantity'],
                );
            }
        }

        // We still need the Method and UID in the body so we just add the additional data here
        if ( !empty($orderLines)) {
            $data['OrderLines'] = $orderLines;
        }

        curl_setopt($this->curlSession, CURLOPT_URL, $url);
        curl_setopt($this->curlSession, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($this->curlSession, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($this->curlSession);
        log_curl($this->curlSession, $response, json_encode($data));
        return json_decode($response);
    }

    /**
     * This will change the status of a cart from temporary to pending.
     * After the cart has been changed to pending, one of the gulf employees can
     * accept or reject the cart as appropriate.
     *
     * @param $uid
     * @param $sequenceNo
     * @return mixed
     */
    function submitCart($uid, $sequenceNo) {
        $data = array(
            'Method' => 'submit',
            'UID' => $uid,
            'SequenceNo' => $sequenceNo
        );

        // The url needs the Method and UID params
        $url = $this->url . buildUriString($data);

        curl_setopt($this->curlSession, CURLOPT_URL, $url);
        curl_setopt($this->curlSession, CURLOPT_CONNECTTIMEOUT, 60);
        $response = curl_exec($this->curlSession);
        log_curl($this->curlSession, $response);
        return json_decode($response);
    }

    function __destruct()
    {
        curl_close($this->curlSession);
    }

}
