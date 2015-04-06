<?php
Class Customer {
	
	private $addressLine1;
	private $addressLine2;
	private $addressLine3;
	private $agingCategory1;
	private $agingCategory2;
	private $agingCategory3;
	private $agingCategory4;
	private $aRDivisionNo;
	private $avgDaysOverDue;
	private $avgDaysPaymentInvoice;
	private $balanceForward;
	private $batchFax;
	private $city;
	private $comment;
	private $contactCode;
	private $countryCode;
	private $customerDiscountRate;
	private $customerName;
	private $customerNo;
	private $customerType;
	private $eMBConsumerUserID;
	private $eMBEnabled;
	private $emailAddress;
	private $emailStatements;
	private $faxNo;
	private $primaryShipToCode;
	private $printDunningMessage;
	private $residentialAddress;
	private $retentionAging1;
	private $retentionAging2;
	private $retentionAging3;
	private $retentionAging4;
	private $retentionCurrent;
	private $shipMethod;
	private $sortField;
	private $state;
	private $telephoneNo;
	private $telephoneExt;
	private $termsCode;
	private $zipCode;
	private $uRLAddress;


	/**
	 * Constructor
	 */
	public function __construct() {
		
	}
	
	/**
	 * -------------------------------------------------------------------------
	 * Setters
	 * -------------------------------------------------------------------------
	 */
	public function setAddressLine1($newAddressLine1) {
		$this->addressLine1 = $newAddressLine1;
	}

	public function setAddressLine2($addressLine2) {
		$this->addressLine2 = $addressLine2;
	}

	public function setAddressLine3($addressLine3) {
		$this->addressLine3 = $addressLine3;
	}

	public function setAgingCategory1($agingCategory1) {
		$this->agingCategory1 = $agingCategory1;
	}

	public function setAgingCategory2($agingCategory2) {
		$this->agingCategory2 = $agingCategory2;
	}

	public function setAgingCategory3($agingCategory3) {
		$this->agingCategory3 = $agingCategory3;
	}

	public function setAgingCategory4($agingCategory4) {
		$this->agingCategory4 = $agingCategory4;
	}

	public function setARDivisionNo($aRDivisionNo) {
		$this->aRDivisionNo = $aRDivisionNo;
	}

	public function setAvgDaysOverDue($avgDaysOverDue) {
		$this->avgDaysOverDue = $avgDaysOverDue;
	}

	public function setAvgDaysPaymentInvoice($avgDaysPaymentInvoice) {
		$this->avgDaysPaymentInvoice = $avgDaysPaymentInvoice;
	}

	public function setBalanceForward($balanceForward) {
		$this->balanceForward = $balanceForward;
	}

	public function setBatchFax($batchFax) {
		$this->batchFax = $batchFax;
	}

	public function setCity($city) {
		$this->city = $city;
	}

	public function setComment($comment) {
		$this->comment = $comment;
	}

	public function setContactCode($contactCode) {
		$this->contactCode = $contactCode;
	}

	public function setCountryCode($countryCode) {
		$this->countryCode = $countryCode;
	}

	public function setCustomerDiscountRate($customerDiscountRate) {
		$this->customerDiscountRate = $customerDiscountRate;
	}

	public function setCustomerName($customerName) {
		$this->customerName = $customerName;
	}

	public function setCustomerNo($customerNo) {
		$this->customerNo = $customerNo;
	}

	public function setCustomerType($customerType) {
		$this->customerType = $customerType;
	}

	public function setEMBConsumerUserID($eMBConsumerUserID) {
		$this->eMBConsumerUserID = $eMBConsumerUserID;
	}

	public function setEMBEnabled($eMBEnabled) {
		$this->eMBEnabled = $eMBEnabled;
	}

	public function setEmailAddress($emailAddress) {
		$this->emailAddress = $emailAddress;
	}

	public function setEmailStatements($emailStatements) {
		$this->emailStatements = $emailStatements;
	}

	public function setFaxNo($faxNo) {
		$this->faxNo = $faxNo;
	}

	public function setPrimaryShipToCode($primaryShipToCode) {
		$this->primaryShipToCode = $primaryShipToCode;
	}

	public function setPrintDunningMessage($printDunningMessage) {
		$this->printDunningMessage = $printDunningMessage;
	}

	public function setResidentialAddress($residentialAddress) {
		$this->residentialAddress = $residentialAddress;
	}

	public function setRetentionAging1($retentionAging1) {
		$this->retentionAging1 = $retentionAging1;
	}

	public function setRetentionAging2($retentionAging2) {
		$this->retentionAging2 = $retentionAging2;
	}

	public function setRetentionAging3($retentionAging3) {
		$this->retentionAging3 = $retentionAging3;
	}

	public function setRetentionAging4($retentionAging4) {
		$this->retentionAging4 = $retentionAging4;
	}

	public function setRetentionCurrent($retentionCurrent) {
		$this->retentionCurrent = $retentionCurrent;
	}

	public function setShipMethod($shipMethod) {
		$this->shipMethod = $shipMethod;
	}

	public function setSortField($sortField) {
		$this->sortField = $sortField;
	}

	public function setState($state) {
		$this->state = $state;
	}

	public function setTelephoneNo($telephoneNo) {
		$this->telephoneNo = $telephoneNo;
	}

	public function setTelephoneExt($telephoneExt) {
		$this->telephoneExt = $telephoneExt;
	}

	public function setTermsCode($termsCode) {
		$this->termsCode = $termsCode;
	}

	public function setZipCode($zipCode) {
		$this->zipCode = $zipCode;
	}

	public function setURLAddress($uRLAddress) {
		$this->uRLAddress = $uRLAddress;
	}

	/**
	 * -------------------------------------------------------------------------
	 * Getters
	 * -------------------------------------------------------------------------
	 */
	public function getAddressLine1() {
		return $this->addressLine1;
	}

	public function getAddressLine2() {
		return $this->addressLine2;
	}

	public function getAddressLine3() {
		return $this->addressLine3;
	}

	public function getAgingCategory1() {
		return $this->agingCategory1;
	}

	public function getAgingCategory2() {
		return $this->agingCategory2;
	}

	public function getAgingCategory3() {
		return $this->agingCategory3;
	}

	public function getAgingCategory4() {
		return $this->agingCategory4;
	}

	public function getARDivisionNo() {
		return $this->aRDivisionNo;
	}

	public function getAvgDaysOverDue() {
		return $this->avgDaysOverDue;
	}

	public function getAvgDaysPaymentInvoice() {
		return $this->avgDaysPaymentInvoice;
	}

	public function getBalanceForward() {
		return $this->balanceForward;
	}

	public function getBatchFax() {
		return $this->batchFax;
	}

	public function getCity() {
		return $this->city;
	}

	public function getComment() {
		return $this->comment;
	}

	public function getContactCode() {
		return $this->contactCode;
	}

	public function getCountryCode() {
		return $this->countryCode;
	}

	public function getCustomerDiscountRate() {
		return $this->customerDiscountRate;
	}

	public function getCustomerName() {
		return $this->customerName;
	}

	public function getCustomerNo() {
		return $this->customerNo;
	}

	public function getCustomerType() {
		return $this->customerType;
	}

	public function getEMBConsumerUserID() {
		return $this->eMBConsumerUserID;
	}

	public function getEMBEnabled() {
		return $this->eMBEnabled;
	}

	public function getEmailAddress() {
		return $this->emailAddress;
	}

	public function getEmailStatements() {
		return $this->emailStatements;
	}

	public function getFaxNo() {
		return $this->faxNo;
	}

	public function getPrimaryShipToCode() {
		return $this->primaryShipToCode;
	}

	public function getPrintDunningMessage() {
		return $this->printDunningMessage;
	}

	public function getResidentialAddress() {
		return $this->residentialAddress;
	}

	public function getRetentionAging1() {
		return $this->retentionAging1;
	}

	public function getRetentionAging2() {
		return $this->retentionAging2;
	}

	public function getRetentionAging3() {
		return $this->retentionAging3;
	}

	public function getRetentionAging4() {
		return $this->retentionAging4;
	}

	public function getRetentionCurrent() {
		return $this->retentionCurrent;
	}

	public function getShipMethod() {
		return $this->shipMethod;
	}

	public function getSortField() {
		return $this->sortField;
	}

	public function getState() {
		return $this->state;
	}

	public function getTelephoneNo() {
		return $this->telephoneNo;
	}

	public function getTelephoneExt() {
		return $this->telephoneExt;
	}

	public function getTermsCode() {
		return $this->termsCode;
	}

	public function getZipCode() {
		return $this->zipCode;
	}

	public function getURLAddress() {
		return $this->uRLAddress;
	}


}
