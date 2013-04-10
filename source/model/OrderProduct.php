<?php
namespace model;
class OrderProduct {
	private $orderId;
	private $cid;
	private $storeId;
	private $quantity;
	private $auxiliaryOrderId;
	private $deliveryDate;
	private $amount;

	// 		$date = new \DateTime();
	// 		$deliveryDate should be created by the following way:
	// 		$date->add(new \DateInterval('P2D'));
	// 		$deliveryDate = $date->format('Y-m-d');

	// 		$auxiliaryOrderId = 0 && $deliveryDate = '' if products come from
	// 		our own store

	public function __construct($orderId, $cid, $storeId, $quantity,
			$auxiliaryOrderId, $deliveryDate, $amount) {
		$this->orderId = $orderId;
		$this->cid = $cid;
		$this->storeId = $storeId;
		$this->quantity = $quantity;
		$this->auxiliaryOrderId = $auxiliaryOrderId;
		$this->deliveryDate = $deliveryDate;
		$this->amount = $amount;
	}

	public function getOrderId() {
		return $this->orderId;
	}

	public function setOrderId($orderId) {
		$this->orderId = $orderId;
	}

	public function getCid() {
		return $this->cid;
	}

	public function setCid($cid) {
		$this->cid = $cid;
	}

	public function getStoreId() {
		return $this->storeId;
	}

	public function setStoreId($storeId) {
		$this->storeId = $storeId;
	}

	public function getQuantity() {
		return $this->quantity;
	}

	public function setQuantity($quantity) {
		$this->quantity = $quantity;
	}

	public function getAuxiliaryOrderId() {
		return $this->auxiliaryOrderId;
	}

	public function setAuxiliaryOrderId($auxiliaryOrderId) {
		$this->auxiliaryOrderId = $auxiliaryOrderId;
	}

	public function getDeliveryDate() {
		return $this->deliveryDate;
	}

	public function setDeliveryDate($deliveryDate) {
		$this->deliveryDate = $deliveryDate;
	}

	public function getAmount() {
		return $this->amount;
	}

	public function setAmount($amount) {
		$this->amount = $amount;
	}

}