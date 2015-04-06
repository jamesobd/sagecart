<?php

/**
 * Description of catalog_model
 *
 * @author Ken
 */
class Catalog_model extends CI_Model
{
    private $baseUri;
    private $curlSession;
    private $url;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->baseUri = 'catalog';
        $this->url = $this->config->item('sage_api_url') . $this->baseUri;
        // Setup an initial curl session we may want to look into setting up keep alive
        // so we only need one socket per php session.
        $this->curlSession = curl_init();
        // We want a string instead of a boolean
        curl_setopt($this->curlSession, CURLOPT_RETURNTRANSFER, true);
        $this->load->helper('uri_helper');
    }

    public function getByCustomer($uid)
    {
//        return file_get_contents('D:\code\gulf-packing\application\www\js\testcatalog.js');
        $data = array(
            'Method' => 'get',
            'UID' => $uid,
        );
        if($this->session->userdata('UDF_IT_CATEGORY')) {
            $data['Category'] = $this->session->userdata('UDF_IT_CATEGORY');
        }
        $url = $this->url . buildUriString($data);

        curl_setopt($this->curlSession, CURLOPT_URL, $url);
        curl_setopt($this->curlSession, CURLOPT_CONNECTTIMEOUT, 60);
        $response = curl_exec($this->curlSession);
        log_curl($this->curlSession, $response);
        $response = json_decode($response);
        foreach ($response->resource as $resource) {
            if ($resource->CategoryCode == $this->session->userdata('UDF_IT_CATEGORY')) {
                $response->resource = array($resource);
            }
        }

        return $response;
    }
}

