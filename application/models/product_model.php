<?php
class Product_model extends CI_Model {

	private $baseUri;
	private $curlSession;
	private $url;
	function __construct() {
		// Call the Model constructor
		parent::__construct();
		$this->baseUri = 'product';
		$this->url = $this->config->item('sage_api_url') . $this->baseUri;
		// Setup an initial curl session we may want to look into setting up keep alive
		// so we only need one socket per php session.
		$this->curlSession = curl_init();
		// We want a string instead of a boolean
		curl_setopt($this->curlSession, CURLOPT_RETURNTRANSFER, true);
		$this->load->helper('uri_helper');
	}

	/**
	 * Get the requested product details
	 *
	 * @param <String> $itemCode - The number of the product to retrieve
	 * @return <Product> A product
	 *
	 */
	public function getProduct($itemCode, $arDivisionNo, $customerNo) {
		$data = array(
			'Method' => 'get',
			'ItemCode' => $itemCode
		);
		$url = $this->url . buildUriString($data);

		curl_setopt($this->curlSession, CURLOPT_URL, $url);
        curl_setopt($this->curlSession, CURLOPT_CONNECTTIMEOUT, 60);
        $response = curl_exec($this->curlSession);
        log_curl($this->curlSession, $response);
        return json_decode($response);
	}
}
