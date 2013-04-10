<?php
session_start();

use model\DbLayer;
use model\TransactionLayer;
use model\CustomerOrder;
use model\OrderProduct;
use model\Store;

include_once ('../model/DbLayer.php');
include_once ('../model/CustomerOrder.php');
include_once ('../model/OrderProduct.php');
include_once ('../model/Store.php');
include_once ('../model/TransactionLayer.php');

include_once '../model/DbLayer.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == "GET"){
	$auth = $_GET["auth"];
	$transactionId = $_GET["tx"];
	
	if (!isset($transactionId) || trim($transactionId) === ""){
		$message = "Unexpected error happended. 
				Please contact our technical support team for help.";
		echo $message;
	}
	else if (!isset($auth) || $auth === ""){
		$message = "Your payment is not completed. 
				You are not charged with anything. 
				Please try again. We're sorry for any inconvenience.";
		echo $message;
	}
	else {
		$dbLayer = new DbLayer();
		$traLayer = new TransactionLayer();		
		$traInfo = $traLayer->getTransactionForOrder($transactionId);
		if (count($traInfo) == 0){
			$message = "Invalid transction info. If you believe this is an error, 
					please see our technical support team for help. Thank you.";
			echo $message;
		}
		else{
			$res = $dbLayer->addOrder($traInfo[0], $traInfo[1]);
			if ($res == 0){
				echo "Our system is experiency a difficulty. Please contact our technical team for help.";
			}
			else {
				echo "Your transaction is completed. Your order number is ".$res;
				echo "<a href='http://cs410.cs.ualberta.ca:41041'>Click here to return to our store</a>";
			}	
		}	
	}	
}
?>
