<?php

/**
 * Description of cart_model
 *
 * @author Ken
 */
class Cart_model extends CI_Model {

    private $collection = 'cart';

    /**
     *
     */
    public function __construct() {
		parent::__construct();
		$this->load->library('mongo_db');
	}

    /**
     * @param $email
     * @param string $salesOrder
     * @param string $sequenceNo
     * @return mixed
     */
    public function updateCart($email, $salesOrder = '', $sequenceNo = '') {

        if (empty($salesOrder)) {
            // delete cart
        }

        $salesOrderArray = $salesOrder;
		$where = array('ContactEmail' => $email);
		$options = array('upsert' => true);
        $result = $this->mongo_db->where($where)
            ->set("SalesOrder", $salesOrderArray)
            ->set("SequenceNo", $sequenceNo)
            ->update($this->collection, $options);
		return $result;
	}

    /**
     * @param $email
     * @return array
     */
    public function getCart($email) {
		$query = array('ContactEmail' => $email);
		$result = $this->mongo_db->where($query)
				->get($this->collection);
		
		// Is there at least one result?
		return !empty($result) ? $result[0] : Array();
	}

}
