<?php
class Sales_order_model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}

    /**
     * Get the requested sales order
     *
     * @param $logon
     * @param $companyCode
     * @param $salesOrderNo
     * @internal param $ <Logon> $logon - The user name and password to be used for the operation
     * @internal param $ <String> $companyCode - The company from which to obtain the sales order
     * @internal param $ <String> $salesOrderNo - The number of the sales order to retrieve
     * @return void <SalesOrder>
     */
	public function getSalesOrder($logon, $companyCode, $salesOrderNo) {

	}

    /**
     * Get the next sales order number
     *
     * @param $logon
     * @param $companyCode
     * @internal param $ <Logon> $logon - The user name and password to be used for the operation
     * @internal param $ <String> $companyCode - The company from which to obtain the sales order
     * @return void <String>
     */
	public function getNextSalesOrderNo($logon, $companyCode) {

	}

    /**
     * Get an empty sales order with the default customer information set
     *
     * @param $logon
     * @param $companyCode
     * @param $arDivisionNo
     * @param $customerNo
     * @internal param $ <Logon> $logon - The user name and password to be used for the operation
     * @internal param $ <String> $companyCode - The company from which to obtain the order template
     * @internal param $ <String> $arDivisionNo - The division number of the customer
     * @internal param $ <String> $customerNo - The customer number to use for the template
     * @return void <SalesOrder>
     */
	public function getSalesOrderTemplate($logon, $companyCode, $arDivisionNo, $customerNo) {

	}

    /**
     * Get a sales order that includes the default values and totals that would
     * be committed if the submitted sales order was passed to the
     * createSalesOrder operation.
     *
     * @param $logon
     * @param $companyCode
     * @param $salesOrder
     * @internal param $ <Logon> $logon - The user name and password to be used for the operation
     * @internal param $ <String> $companyCode - The company from which to preview the sales order
     * @internal param $ <SalesOrder> $salesOrder - The sales order to preview
     * @return void <SalesOrder>
     */
	public function previewSalesOrder($logon, $companyCode, $salesOrder) {

	}

	/**
	 * This operation creates a sales order in the Sage ERP system.
	 *
	 * The salesOrderNo field of salesOrder must be set to create a sales order.
	 * The getNextSalesOrderNo operation can be used to obtain a sales order
	 * number.
	 *
	 * @param <Logon> $logon - The user name and password to be used for the operation
	 * @param <String> $companyCode - The company in which to create the sales order
	 * @param <SalesOrder> $salesOrder - The sales order to create
	 *
	 * TODO: Implement me if needed
	 */
	public function createSalesOrder($logon, $companyCode, $salesOrder) {

	}

	/**
	 * This operation updates a sales order in the Sage ERP system.
	 *
	 * A sales order must first be obtained from the getSalesOrder operation.
	 * This sales order can then be modified and passed to the updateSalesOrder
	 * operation.
	 *
	 * @param <Logon> $logon - The user name and password to be used for the operation
	 * @param <String> $companyCode - The company from which to update the sales order
	 * @param <SalesOrder> $salesOrder - The sales order to update
	 *
	 * TODO: Implement me if needed
	 */
	public function updateSalesOrder($logon, $companyCode, $salesOrder) {

	}

	/**
	 * This operation deletes the specified sales order from the Sage ERP system.
	 *
	 * @param <Logon> $logon - The user name and password to be used for the operation
	 * @param <String> $companyCode - The company from which to delete the sales order
	 * @param <String> $salesOrderNo - The sales order to delete
	 *
	 * TODO: Implement me if needed
	 */
	public function deleteSalesOrder($logon, $companyCode, $salesOrderNo) {

	}

}
