<?php
namespace model;
use model\CustomerOrder;
include_once "CustomerOrder.php";
class TransactionOrder extends CustomerOrder {

	private $validity;

	public function __construct($orderId, $description, $orderDate, $username,
			$payment, $deliveryDate) {
		parent::__construct($orderId, $description, $orderDate, $username,
				$payment, $deliveryDate);
		$this->validity = 1;
	}

	public function getValidity() {
		return $this->validity;
	}

	public function setValidity($validity) {
		$this->validity = $validity;
	}

}
