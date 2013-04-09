<?php
namespace model;
use model\CustomerOrder;
include_once "CustomerOrder.php";
class TransactionOrder extends CustomerOrder {

	public function __construct($orderId, $description, $orderDate, $username,
			$payment, $deliveryDate) {	
		parent::__construct($orderId, $description, $orderDate, $username, $payment, $deliveryDate);
	}
}
