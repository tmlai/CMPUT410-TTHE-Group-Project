<?php
namespace model;
class CustomerOrder {
	private $orderId;
	private $description;
	private $orderDate;
	private $username;
	private $payment;
	private $deliveryDate;

	private $orderCost;

	/*
	 * $orderId can be some random number if the object is inserted into table.
	 */
	public function __construct($orderId, $description, $orderDate, $username,
			$payment, $deliveryDate) {
		$this->orderId = $orderId;
		$this->description = $description;
		$this->orderDate = $orderDate;
		$this->username = $username;
		$this->payment = $payment;
		$this->deliveryDate = $deliveryDate;
		$this->orderCost = 0;
	}

	public function getOrderId() {
		return $this->orderId;
	}

	public function setOrderId($orderId) {
		$this->orderId = $orderId;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getOrderDate() {
		return $this->orderDate;
	}

	public function setOrderDate($orderDate) {
		$this->orderDate = $orderDate;
	}

	public function getUsername() {
		return $this->username;
	}

	public function setUsername($username) {
		$this->username = $username;
	}

	public function getPayment() {
		return $this->payment;
	}

	public function setPayment($payment) {
		$this->payment = $payment;
	}

	public function getDeliveryDate() {
		return $this->deliveryDate;
	}

	public function setDeliveryDate($deliveryDate) {
		$this->deliveryDate = $deliveryDate;
	}

	public function getOrderCost() {
		return $this->orderCost;
	}

	public function setOrderCost($orderCost) {
		$this->orderCost = $orderCost;
	}

}