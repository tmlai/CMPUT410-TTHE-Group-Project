<?php
namespace model;
use model\DbLayer;
use model\TransactionOrder;
use model\TransactionProduct;
include_once "TransactionOrder.php";
include_once "TransactionProduct.php";
include_once "DbLayer.php";
class TransactionLayer {
	
	/* 
	 * Given the $transactionId, return two things in an array
	 * [1]: TransactionOrder object
	 * [2]: array of TransactionProduct object
	 */
	public function getTransactionForOrder($transactionId){
		$pdo = DbLayer::getPdo();
		$statement = "SELECT * FROM TransactionsOrders WHERE orderId = ?";
		$stmt = $pdo->prepare($statement);
		$array = array($transactionId);
		$stmt->execute($array);
		
		$temp = $stmt->fetchAll();
		$traOrd = null;
		foreach($temp as &$row){
			$traOrd = new CustomerOrder($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
		}
		
		$statement = "SELECT * FROM TransactionsProducts WHERE orderId = ?";
		$stmt = $pdo->prepare($statement);
		$array = array($transactionId);
		$stmt->execute($array);
		$temp = $stmt->fetchAll();
		
		$listTraProd = array();
		foreach($temp as &$each){
			$oneTraProd = new OrderProduct($each[0], $each[1], $each[2], $each[3], $each[4], $each[5], $each[6]);
			$listTraProd[] = $oneTraProd;
		}
		
		return array($traOrd,$listTraProd);
		
	}
	
	/*
	 * Add just one product ordered to the transaction tables.
	* Parameters:	$pdo:			  	the pdo connection
	* 				$TransactionProduct	TransactionProduct object to be inserted.
	* Return type:	true if insert successfully, false otherwise.
	* NOTE: 		pass the pdo connection so that this database action can be rollbacked
	* 				since this action is a small step in a transaction.
	*/
	public function transactOneProduct(\PDO $pdo, TransactionProduct $transactProduct) {
		$statement = "INSERT INTO TransactionsProducts values(?,?,?,?,?,?,?)";
		$stmt = $pdo->prepare($statement);
	
		$array = array($transactProduct->getOrderId(), $transactProduct->getCid(),
				$transactProduct->getStoreId(), $transactProduct->getQuantity(),
				$transactProduct->getAuxiliaryOrderId(),
				$transactProduct->getDeliveryDate(), $transactProduct->getAmount());
		$value = $stmt->execute($array);
		return $value;
	}
	
	/*
	 * Add a list of products ordered to the database.
	* Parameters:	$transactionOrder	TransactionOrder object representing a new tuple
	* 								to be inserted into TransactionsOrders table.
	* 				$transactionProductsArray	array of TransactionProduct objects to be inserted
	* 								into TransationsProducts table.
	* Return type:	true if successfully adding all tuples into tables. False
	* otherwise.
	*/
	public function addTransaction(TransactionOrder $transactionOrder,
			array $transactionProductsArray) {
		$pdo = DbLayer::getPdo();
		$pdo->beginTransaction();
	
		$statement = "INSERT INTO TransactionsOrders(description,orderDate,username,payment,deliveryDate)
		values(?,?,?,?,?)";
		$stmt = $pdo->prepare($statement);
	
		$date = new \DateTime();
		$orderDate = $date->format('Y-m-d H:i:s');
	
		$date->add(new \DateInterval('P2D'));
		$deliveryDate = $date->format('Y-m-d');
	
		$array = array($transactionOrder->getDescription(), $orderDate,
				$transactionOrder->getUsername(), $transactionOrder->getPayment(),
				$deliveryDate);
	
		$value = $stmt->execute($array);
		$value = ($value == true && $stmt->rowCount() > 0);
		if ($value == false) {
			$pdo->rollBack();
			// TODO
			echo "TransactionsOrders insert";
			$pdo = null;
			return 0;
		}
	
		$orderId = $pdo->lastInsertId();
		
		// modify orderId
		foreach($transactionProductsArray as &$onetp){
			/* @var $onetp TransactionProduct */
			$onetp->setOrderId($orderId);
		}
	
		
		// 		Insert each tuple into TransactionsProducts table.
		$tsLayer = new TransactionLayer();
		foreach ($transactionProductsArray as &$op) {
			$value = $tsLayer->transactOneProduct($pdo, $op);
			if ($value == false) {
				$pdo->rollBack();
				// TODO
				echo "TransactionProduct insert";
				$pdo = null;
				return 0;
			}
		}
	
		$pdo->commit();
		$pdo = null;
		return $orderId;
	}
	
	
}
