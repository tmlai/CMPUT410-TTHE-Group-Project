<?php
namespace model;
use model\OrderProduct;
include_once "OrderProduct.php";
class TransactionProduct extends OrderProduct {
	
	public function __construct($orderId, $cid, $storeId, $quantity,
			$auxiliaryOrderId, $deliveryDate, $amount) {
		parent::__construct($orderId, $cid, $storeId, $quantity, $auxiliaryOrderId, $deliveryDate, $amount);
	}
}